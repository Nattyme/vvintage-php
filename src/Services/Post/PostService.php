<?php 
declare(strict_types=1);

namespace Vvintage\Services\Post;

use Vvintage\Repositories\Post\PostRepository;
use Vvintage\Repositories\PostCategory\PostCategoryRepository;
use Vvintage\Models\Post\Post;
use Vvintage\DTO\Post\PostDTO;

final class PostService
{
    private array $languages;
    private string $currentLang;
    private PostRepository $postRepository;
    private PostCategoryRepository $postCategoryRepository;

    public function __construct(array $languages, string $currentLang)
    {
      $this->languages = $languages;
      $this->currentLang = $currentLang;
      $this->postRepository = new PostRepository ( $this->currentLang );
      $this->postCategoryRepository = new PostCategoryRepository ( $this->currentLang );
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
}
