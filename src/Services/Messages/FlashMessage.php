<?php
declare(strict_types=1);

namespace Vvintage\Services\Messages;
use Vvintage\Services\Session\SessionService;



final class FlashMessage
{
  private SessionService $sessionService;
  private array $messages = [];

  public function __construct(
    SessionService $sessionService
  )
  {
    $this->sessionService = $sessionService;
    $this->messages = $this->sessionService->getFlashNotes();
  }
    public function pushError(string $title, ?string $desc = null, ?string $flag = null) {
        $this->addMessage('errors', $title, $desc, $flag);
    }

    public function pushSuccess(string $title, ?string $desc = null, ?string $flag = null) {
        $this->addMessage('success', $title, $desc, $flag);
    }


    private function addMessage(string $type, string $title, ?string $desc = null, ?string $flag = null) {
        $message = ['title' => $title];

        if ($desc !== null) {
            $message['desc'] = $desc;
        }

        if ($flag !== null) {
            $message['flag'] = $flag;
        }

        $this->sessionService->setSessionByKey($type, $message);
        
        $this->messages['success'] = $this->sessionService->getSessionByKey('success') ?? [];
        $this->messages['errors'] = $this->sessionService->getSessionByKey('errors') ?? [];
    }

    public function get(string $type): array {
      $messages = $_SESSION[$type] ?? [];
      // unset($_SESSION[$type]); // очищаем, чтобы показывались только один раз
      return $messages;
    }

}
