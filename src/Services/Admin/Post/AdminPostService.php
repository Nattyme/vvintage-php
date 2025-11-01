<?php 
declare(strict_types=1);

namespace Vvintage\Services\Admin\Post;

use Vvintage\Services\Post\PostService;
use Vvintage\DTO\Admin\Post\PostEditDTO;
use Vvintage\DTO\Admin\Post\PostEditDTOFactory;
use Vvintage\Services\Locale\LocaleService;
use Vvintage\Config\LanguageConfig; // Пеервод на другие языки

final class AdminPostService extends PostService
{
    private array $actions = [
      'hide'     => 'Скрыть',
      'show'     => 'Показать',
      'archived' => 'В архив'
    ];

    public function __construct(  protected LocaleService $localeService )
    {
      parent::__construct(LanguageConfig::getAvailableLanguages(), $this->localeService->getCurrentLang());
    }

    public function getPostEditData(int $id): ?PostEditDTO
    {
      $post = $this->getPostById ($id);
      $dtoFactory = new PostEditDTOFactory($this->localeService);
      return $dtoFactory->createFromPost($post) ?? null;
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
