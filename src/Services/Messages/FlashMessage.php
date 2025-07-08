<?php
declare(strict_types=1);

namespace Vvintage\Services\Messages;


final class FlashMessage
{
  public function renderError (string $title, ?string $desc = null) {
    $this->addMessage('errors', $title, $desc);
  }

  public function renderSuccess (string $title, ?string $desc = null) {
    $this->addMessage('success', $title, $desc);
  }

  private function addMessage (string $type, string $title, string $desc = null) {
      if ( $desc === null) {
       return $_SESSION[$type][] = [$type, $title];
     }

     return $_SESSION[$type][] = ['title' => $title, 'desc' => $desc];
  }
}