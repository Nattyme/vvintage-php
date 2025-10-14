<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin\Post;

use Vvintage\Services\Post\PostService;


final class AdminPostService extends PostService
{
    private array $actions = [
      'hide'     => 'Скрыть',
      'show'     => 'Показать',
      'archived' => 'В архив'
    ];

    public function __construct(array $languages, string $currentLang)
    {
      parent::__construct($languages, $currentLang);
    }

    public function handleStatusAction(array $data): void 
    {

        if ( 
          isset($data['action-submit']) && 
          (isset($data['action']) && !empty($data['action'])) &&
          (isset($data['posts']) && !empty($data['posts'])) ) {
          $action = $data['action'];

          foreach ($data['posts'] as $key=> $postId) {
            $this->applyAction((int) $postId, $action);
          }

        }

    }

    // change product status
    public function getActions(): array 
    {
      return $this->actions;
    }


    public function publishPost(int $postId): bool
    {

        return $this->repository->updateStatus($postId, 'active');
    }

  public function hidePost(int $postId): bool
  {
      return $this->repository->updateStatus($postId, 'hidden');
  }

  public function archivePost(int $postId, bool $keepAllImages = true): bool
  {
      $result = $this->repository->updateStatus($postId, 'archived');

      if ($result && !$keepAllImages) {
          $this->repository->deleteExtraImagesExceptMain($postId);
      }

      return $result;
  }

}
