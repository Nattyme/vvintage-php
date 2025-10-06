<?php 
declare(strict_types=1);

namespace Vvintage\Services\Post;

use Vvintage\Services\Base\BaseService;
use Vvintage\Repositories\Post\PostRepository;
use Vvintage\Repositories\PostCategory\PostCategoryRepository;
use Vvintage\Models\Post\Post;
use Vvintage\DTO\Post\PostDTO;

class PostService extends BaseService
{
    private PostRepository $postRepository;
    private PostCategoryRepository $postCategoryRepository;

    public function __construct()
    {
      $this->postRepository = new PostRepository ();
      $this->postCategoryRepository = new PostCategoryRepository ();
    }

    public function getAllPosts(array $pagination): array
    {
        return $this->postRepository->getAllPosts($pagination);

        // return array_map(
        //     fn($bean) => Post::fromDTO($bean),
        //     $beans
        // );
    }

    public function getTotalCount(): int
    {
        return $this->postRepository->getAllPostsCount();
    }

    public function add(PostDTO $dto): int
    {
        $post = Post::fromDTO($dto);
        return $this->postRepository->save($post);
    }

    public function getPost(int $id)
    {
      return $this->postRepository->getPostById($id);
    }

    // public function getPostMainCategory(int $id)
    // {

    // }

    public function getAllMainCategories(): array
    { 
      return $this->postCategoryRepository->getMainCats();
    }

    public function getAllSubCategories(): array
    { 
      return $this->postCategoryRepository->getSubCats();
    }

    public function getLastPosts(int $count)
    {
       return $this->postRepository->getPostsByIds([3, 2 , 1]);
    }

    public function getBlogData ( array $pagination): array
    {
      $posts = $this->getAllPosts($pagination);
      $mainCategories = $this->getAllMainCategories();
      $subCategories = $this->getAllSubCategories();
      $totalPosts = $this->getTotalCount();

      return [
        'posts' => $posts,
        'mainCategories' => $mainCategories,
        'subCategories' => $subCategories,
        'totalPosts' => $totalPosts
      ];
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
}
