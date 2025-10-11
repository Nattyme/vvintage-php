<?php 
declare(strict_types=1);

namespace Vvintage\Services\Post;

use Vvintage\Services\Base\BaseService;

/* Repository */
use Vvintage\Repositories\Post\PostRepository;
use Vvintage\Repositories\Post\PostTranslationRepository;
use Vvintage\Services\PostCategory\PostCategoryService;

/** Model */
use Vvintage\Models\Post\Post;

/** DTO */
use Vvintage\DTO\Post\PostDTO;
use Vvintage\DTO\Post\PostListDto;
use Vvintage\DTO\Post\PostCardDTO;

class PostService extends BaseService
{
    private PostRepository $repository;
    private PostTranslationRepository $translationRepo;
    private PostCategoryService $categoryService;

    public function __construct()
    {
      parent::__construct(); // Важно!
      $this->repository = new PostRepository ();
      $this->translationRepo = new PostTranslationRepository();
      $this->categoryService = new PostCategoryService();
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

    public function getBlogData ( array $pagination): array
    {
      $posts = $this->getAllPosts($pagination);
      dd($posts);
      $mainCategories = $this->getAllMainCategories($this->currentLang);
    
      $subCategories = $this->getAllSubCategories($this->currentLang);
      $relatedPosts = $blogData['posts'];
      $totalPosts = $this->getTotalCount();

      return [
        'posts' => $posts,
        'mainCategories' => $mainCategories,
        'subCategories' => $subCategories,
        'relatedPosts' => $relatedPosts,
        'totalPosts' => $totalPosts
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
