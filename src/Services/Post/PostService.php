<?php 
declare(strict_types=1);

namespace Vvintage\Services\Post;

use Vvintage\Services\Base\BaseService;

/* Repository */
use Vvintage\Repositories\Post\PostRepository;
use Vvintage\Repositories\Post\PostTranslationRepository;

/**Services */
use Vvintage\Services\PostCategory\PostCategoryService;
use Vvintage\Services\Shared\PaginationService;

/** Model */
use Vvintage\Models\Post\Post;

/** DTO */
use Vvintage\DTO\Post\PostDTO;
use Vvintage\DTO\Post\PostListDto;
use Vvintage\DTO\Post\PostCardDTO;
use Vvintage\DTO\Post\PostFilterDTO;

class PostService extends BaseService
{
    private PostRepository $repository;
    private PostTranslationRepository $translationRepo;
    private PostCategoryService $categoryService;
    protected PaginationService $paginationService;

    public function __construct()
    {
      parent::__construct(); // Важно!
      $this->repository = new PostRepository ();
      $this->translationRepo = new PostTranslationRepository();
      $this->categoryService = new PostCategoryService();
      $this->paginationService = new PaginationService();
      // $this->postCategoryRepository = new PostCategoryRepository ();
    }

    public function getAllPosts(array $pagination): array
    {
        return $this->repository->getAllPosts($pagination);

        // return array_map(
        //     fn($bean) => Post::fromDTO($bean),
        //     $beans
        // );
    }

    private function getPostById (int $id): Post
    {
        $post = $this->repository->getPostById($id);

        if (! $post ) {
            return [];
        }

        $translations = $this->translationRepo->getLocaleTranslation((int) $id, $this->currentLang) 
        ?? 
        $this->translationRepo->getLocaleTranslation((int) $id, $this->currentLang);
        $post->setTranslations($translations);

        $category = $this->categoryService->getLocaledCategory($id);
        $post->setCategory($category);


        return $post;

        // $postId = (int) $row['id'];

        // $translations = $this->translationRepo->loadTranslations($postId);
    
        // $categoryDTO = $this->createCategoryOutputDTO($row);

        // $dto = new PostDTO([
        //     'id' => (int) $row['id'],
        //     'categoryDTO' => $categoryDTO,
        //     'title' => (string) $row['title'],
        //     'description' => (string) $row['description'],
        //     'content' => (string) $row['content'],
        //     'slug' => (string) $row['slug'],
        //     'views' => (int) $row['views'],
        //     'cover' => (string) $row['cover'],
        //     'cover_small' => (string) $row['cover_small'],
        //     'datetime' => (string) $row['datetime'],
        //     'translations' => $translations,
        //     'locale' => $this->currentLang ?? self::DEFAULT_LANG
        // ]);

        // return Post::fromDTO($dto);
    }


    public function getFilteredPosts(PostFilterDTO $filters, ?int $perPage = null): array 
    {
      //  dd($filters);
      $categories = !empty($filters->categories) ? $filters->categories : null;
    
      if( $categories && count( $categories) === 1) {
        $id = (int) $categories[0];
        $category = $this->categoryService->getCategoryById($id) ?? null;
        $parent_id = $category->getParentId() ?? null;
    
        if(!$parent_id) {
          $subCategories = $this->categoryService->getSubCategoriesArray($id);
          
          // Получаем только id из массива подкатегорий
          $subCategoryIds = array_column($subCategories, 'id');

          // Теперь можно подставить эти id в фильтр
          if (!empty($subCategoryIds)) {
              $filters->categories = $subCategoryIds;
          }
        }
      
      }

      if ($filters instanceof PostFilterDTO) {
          $filters = [
              'categories' => $filters->categories,
              'sort'       => $filters->sort
          ];
      }

      // Получаем массив продуктов по фильтру
      $posts = $this->repository->getPosts($filters);

      if( $perPage) {
        $totalItems = count($posts);   // Считаем общее кол-во
        // Добавляем данные по пагинации в фильтр
        $filters = $this->addPaginationToFilter($filters, $totalItems, $perPage);
 
        // Теперь получаем только продукты для этой страницы
        $posts = $this->repository->getPosts($filters);
        
      }

      $dtos = [];
      foreach ($posts as $model) {
          $modelFull = $this->setDataToPostModel($model);
          $dtos[] = new PostListDTO($modelFull, $this->currentLang);
      }

      return ['posts' => $dtos, 'total' => $totalItems, 'filters' => $filters];
    }
    
    public function getLastPosts(int $count): array
    {
        $models = $this->repository->getLastPosts($count);
        if (!$models) {
            return [];
        }

        $dtos = [];
        foreach ($models as $model) {
            $modelFull = $this->setDataToPostModel($model);
            $dtos[] = new PostCardDTO($modelFull, $this->currentLang);
        }

        return $dtos;
    }

    private function addPaginationToFilter($filters, $totalItems, $perPage)
    {
      $currentPage = isset($_GET['page']) ? (int)$_GET['page'] : 1;
      $pagination = $this->paginationService->paginate( totalItems: $totalItems, currentPage: $currentPage, perPage: $perPage);

      // Добавляем пагинацию в фильтры
      $filters['pagination']['page_number'] = $pagination['current_page'];
      $filters['pagination']['perPage'] = $pagination['perPage'];
      $filters['pagination']['number_of_pages'] = $pagination['number_of_pages'];
      $filters['pagination']['offset'] = $pagination['offset'];
  
      // $filters['perPage'] = $pagination['perPage'];
      // $filters['number_of_pages'] = $pagination['number_of_pages'];
      return $filters;
    }

    public function getBlogData(array $getData, int $postsPerPage)
    {
       $filterDto = new PostFilterDTO([
          'categories'=> $getData['category'] ?? [],
          'sort'      => $getData['sort'] ?? null,
          'search' => $getData['q'] ?? null,
          // 'page' =>  $page,
          'perPage' => (int) $postsPerPage ?? 10
      ]);


      // Получаем статьи с учётом пагинации
      $filteredPostsData = $this->getFilteredPosts( filters: $filterDto, perPage: 9);
     
      $posts =  $filteredPostsData['posts'];
      $total = $filteredPostsData['total'];
      $filters = $filteredPostsData['filters'];
      $pagination = $filters['pagination'];

      $mainCategories =  $this->categoryService->getMainCategories();
      $subCategories =  $this->categoryService->getSubCategories();
  
      // $relatedPosts = $blogData['posts'];
      $totalPosts = $this->getTotalCount();

      return [
        'posts' => $posts,
        'mainCategories' => $mainCategories,
        'subCategories' => $subCategories,
        // 'relatedPosts' => $relatedPosts,
        'totalPosts' => $total
      ];
    }

    




















    public function getTotalCount(): int
    {
        return $this->repository->getAllPostsCount();
    }

    public function add(PostDTO $dto): int
    {
        $post = Post::fromDTO($dto);
        return $this->repository->save($post);
    }

    public function getPost(int $id)
    {
      return $this->repository->getPostById($id);
    }

    // public function getPostMainCategory(int $id)
    // {

    // }

    public function getAllMainCategories(): array
    { 
      return $this->postCategoryRepository->getMainCats($this->currentLang);
    }

    public function getAllSubCategories(): array
    { 
      return $this->postCategoryRepository->getSubCats($this->currentLang);
    }

  

  

    public function getPostViewData(int $id): array
    {
      $post = $this->getPost($id);
      $category = $post->getCategory();

      $mainCatId = $category->getParentId();
      $mainCategory =  $this->postCategoryRepository->getPostCatById($mainCatId);
      $allMainCategories = $this->getAllMainCategories();
      $allSubCategories = $this->getAllSubCategories();

      return [
        'post' => $post,
        'category' => $category,
        'mainCategory' =>  $mainCategory,
        'allMainCategories' => $allMainCategories,
        'allSubCategories' => $allSubCategories,
      ];

    }

    private function setDataToPostModel (Post $post): ?Post 
    {
      // Добавим модель категории в пост
      $categoryId = $post->getCategoryId();
      $category = $this->categoryService->getCategoryById($categoryId);
      $post->setCategory($category);

      $id = $post->getId();

      // Добавим перевод в пост
      $translations = $this->translationRepo->loadTranslations($id);
      $post->setTranslations($translations);

      return $post;
    }

    private function createPostDTOFromArray(array $row, ?string $currentLang = null): PostOutputDTO
    {
        $id = (int) $row['id'];

        $tranlations = [];

        if($currentLang) {
          $translations = $this->translationRepo->getTranslationsArray($productId, $currentLang);
        } else {
          $translations = $this->translationRepo->loadTranslations($productId);
        }
        $categoryOutputDTO = $this->categoryService->createCategoryOutputDTO((int) $row['category_id']);
        $brandOutputDTO = $this->brandService->createBrandOutputDTO((int) $row['brand_id']);

        // $brandDTO = $this->brandService->createBrandDTOFromArray($row);
        $imagesDTO = $this->productImageService->createImageDTO($row);

        $images = $this->productImageService->getImageViewData($imagesDTO);
        
        // $datetime = isset($row['datetime']) ? new \DateTime($row['datetime']) : null;

        $dto = new ProductOutputDTO([
          'id' => $row['id'],
          'category_id' => $row['category_id'],
          'category_title' => $categoryOutputDTO->title,
          'categoryDTO' => $categoryOutputDTO,
          'brand_id' => $row['brand_id'],
          'brand_title' => $brandOutputDTO->title,
          'brandDTO' => $brandOutputDTO,
          'slug' => $row['slug'],
          'title' => $translations[$this->currentLang]['title'] ?? $translations['title'],
          'description' => $translations[$this->currentLang]['description'] ?? $translations['description'],
          'price' => $row['price'],
          'url' => $row['url'],
          'sku' => $row['sku'],
          'stock' => $row['stock'],
          'datetime' => $row['datetime'],

          'status' => $row['status'],
          'edit_time' => $row['edit_time'],
          'images' => $images,
          'translations' => $translations
        ]);
 
        return $dto;
     
    }
}
