<?php 
declare(strict_types=1);

namespace Vvintage\Services\Post;

use Vvintage\Repositories\Post\PostRepository;
use Vvintage\Models\Post\Post;
use Vvintage\DTO\Post\PostDTO;

final class PostService
{
    private string $currentLang;
    private PostRepository $postRepository;

    public function __construct(string $currentLang)
    {
        $this->currentLang = $currentLang;
        $this->postRepository = new PostRepository( $this->currentLang );
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
}
