<?php 
declare(strict_types=1);

namespace Vvintage\Services\Blog;

use Vvintage\Repositories\Post\PostRepository;
use Vvintage\Models\Blog\Post;
use Vvintage\DTO\Post\PostDTO;

final class BlogService
{
    private PostRepository $postRepository;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepository = $postRepository;
    }

    public function getAll(array $pagination): array
    {
        $beans = $this->postRepository->getAllPosts($pagination);

        return array_map(
            fn($bean) => Post::fromBean($bean),
            $beans
        );
    }

    public function getTotalCount(): int
    {
        return $this->postRepository->countAll();
    }

    public function add(PostDTO $dto): int
    {
        $post = Post::fromDTO($dto);
        return $this->postRepository->save($post);
    }

    public function getPost(int $id)
    {
      $bean = $this->postRepository->findById($id);
      return Post::fromBean($bean);
    }


    // public function getById(int $id): ?Post {}
    // public function getByCategory(string $slug): array {}
}
