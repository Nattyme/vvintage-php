<?php 
declare(strict_types=1);

namespace Vvintage\Public\Services\Post;

use Vvintage\Public\Services\Base\BaseService;

/* Repository */
use Vvintage\Repositories\Post\PostRepository;
use Vvintage\Repositories\Post\PostTranslationRepository;

/**Services */
use Vvintage\Public\Services\PostCategory\PostCategoryService;
use Vvintage\Public\Services\Shared\PaginationService;
use Vvintage\Utils\Services\Locale\LocaleService;

/** Model */
use Vvintage\Models\Post\Post;

/** DTO */
use Vvintage\Public\DTO\Post\PostDTO;
use Vvintage\Public\DTO\Post\PostListDto;
use Vvintage\Public\DTO\Post\PostCardDTO;
use Vvintage\Public\DTO\Post\PostFilterDTO;
use Vvintage\Public\DTO\Post\PostListDTOFactory;
use Vvintage\Public\DTO\Post\PostFullDTO;
use Vvintage\Public\DTO\Post\PostFullDTOFactory;

class PostService extends BaseService
{
    private PostRepository $repository;
    private PostTranslationRepository $translationRepo;
    private PostCategoryService $categoryService;
    protected PaginationService $paginationService;
    protected LocaleService $localeService;

    public function __construct()
    {
      parent::__construct(); // Важно!
      $this->repository = new PostRepository ();
      $this->translationRepo = new PostTranslationRepository();
      $this->categoryService = new PostCategoryService($this);
      $this->paginationService = new PaginationService();
      $this->localeService = new LocaleService();
    }

    // public function getAll(array $pagination = []): array
    // {
    //     return $this->repository->getPosts();

    //     // return array_map(
    //     //     fn($bean) => Post::fromDTO($bean),
    //     //     $beans
    //     // );
    // }

    public function getPostById (int $id): ?Post
    {
        $post = $this->repository->getPostById($id);

        if (! $post ) {
            return [];
        }

        // Получаем все переводы и устанавливаем в модель
        $translations = $this->translationRepo->loadTranslations($id);
        $post->setTranslations($translations);

        // Получаем модель категории и устанавливаем в модель поста
        $category = $this->categoryService->getCategoryById($id);
        $post->setCategory($category);
      
        return $post;
    }

  

    public function getPostDto (Post $post): ?PostFullDTO
    {
        $dtoFactory = new PostFullDTOFactory($this->localeService);
        return $dtoFactory->createFromPost($post);
    }


    public function getFilteredPosts(PostFilterDTO $filters, ?int $perPage = null): array 
    {
      // Получаем id категорий
      $categories = !empty($filters->categories) ? $filters->categories : null;

      // Проверяем на главную
      $id = (int) $filters->categories;
      $category = $this->categoryService->getCategoryById($id) ?? null;
      $parent_id = $category ? $category->getParentId() : null;

      // Если у категории нет Id родител - значит это главная. Получаем ее подкатегории
      if(!$parent_id) {
  
        $subCategories = $this->categoryService->getSubCategoriesArray($id);
        
        $subCategoryIds = [];
        // Получаем только id из массива подкатегорий
        $subCategoryIds = array_map(fn($subCat) => $subCat->getId(), $subCategories);
    
        // Теперь можно подставить эти id в фильтр
        if (!empty($subCategoryIds)) {
            $filters->categories = $subCategoryIds;
        }
      }
      

     
      // $category = !empty($filters->category) ? $filters->category : null;
      if ($filters instanceof PostFilterDTO) {
          $filters = [
              'categories' => !empty($filters->categories) 
                              ? array_values((array)$filters->categories) // приведение к массиву
                              : [],
              'sort'       => $filters->sort ?? null
          ];
      }

      // Получаем массив постов по фильтру
      $posts = $this->repository->getPosts($filters);

      if( $perPage) {
        $totalItems = count($posts);   // Считаем общее кол-во
        // Добавляем данные по пагинации в фильтр
        $filters = $this->addPaginationToFilter($filters, $totalItems, $perPage);
 
        // Теперь получаем только продукты для этой страницы
        $posts = $this->repository->getPosts($filters);
        
      }

      $dtos = [];
      $dtoFactory = new PostListDTOFactory($this->localeService);
      foreach ($posts as $model) {
          $modelFull = $this->setDataToPostModel($model);
          $dtos[]  = $dtoFactory->createFromPost($modelFull);
      }

      return ['posts' => $dtos, 'total' => $totalItems, 'filters' => $filters];
    }
    
    public function getLastPosts(int $count): array
    {
        $models = $this->repository->getLastPosts($count) ?? [];
      
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

    public function getBlogData($getData, int $postsPerPage): array
    {
    
      $category = $this->categoryService->getCategoryBySlug($getData['slug'] ?? null);
        
      $category_id = $category ? $category->getId() : null;

      $filterDto = new PostFilterDTO(
        categories: [$category_id] ?? [],
        sort: $getData['sort'] ?? [],
        search: $getData['q'] ?? [],
        // 'page' =>  $page,
        perPage: (int) $postsPerPage ?? 10
      );


      // Получаем статьи с учётом пагинации
      $filteredPostsData = $this->getFilteredPosts( filters: $filterDto, perPage: 9);
     dd( $filteredPostsData);
      $posts =  $filteredPostsData['posts'];
      $total = $filteredPostsData['total'];
      $filters = $filteredPostsData['filters'];
      $pagination = $filters['pagination'];

      $mainCategories =  $this->categoryService->getMainCategories();

      $subCategories =  $this->categoryService->getSubCategories();

      // $relatedPosts = $blogData['posts'];
      $totalPosts = $this->getTotalCount();
      $categoryIds = $this->getExistPostsParamsFromColumn('category_id');

      return [
        'posts' => $posts,
        'mainCategories' => $mainCategories,
        'subCategories' => $subCategories,
        'categoryIds' => $categoryIds,
        // 'relatedPosts' => $relatedPosts,
        'totalPosts' => $total
      ];
    }

    public function getPostData(int $id): array
    {
      if(!$id) return null;

      $post = $this->getPostById ($id);
      $postDto = $this->getPostDto($post);
  
      $mainCategories =  $this->categoryService->getMainCategories();
      $subCategories =  $this->categoryService->getSubCategories();
      $categoryIds = $this->getExistPostsParamsFromColumn('category_id');
      // $relatedPosts = $blogData['posts'];
   

      return [
        'post' => $postDto,
        'mainCategories' => $mainCategories,
        'subCategories' => $subCategories,
        'categoryIds' => $categoryIds,
        // 'relatedPosts' => $relatedPosts,
        // 'totalPosts' => $total
      ];
    }

    public function getExistPostsParamsFromColumn(string $column): array 
    {
      return $this->repository->getParamsFromColumn($column);
    }

    // public function getPostsCountByCategory(int $categoryId): int
    // { 
    //   $filterDto = new PostFilterDTO(
    //       categories: $category_id ?? null,
    //   );

    //   return $this->getFilteredPosts($filterDto);
    // }


    public function getAllMainCategories(): array
    { 
      return $this->categoryService->getMainCategories();
    }

    public function getAllSubCategories(): array
    { 
      return $this->categoryService->getSubCategories();
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
