<?php
declare(strict_types=1);

namespace Vvintage\Services\Messages;


final class FlashMessage
{
  public function pushError (string $title, ?string $desc = null) {
    $this->addMessage('errors', $title, $desc);
  }

  public function pushSuccess (string $title, ?string $desc = null) {
    $this->addMessage('success', $title, $desc);
  }

  private function addMessage (string $type, string $title, string $desc = null) {
    if ( $desc === null) {
      return $_SESSION[$type][] = ['title' => $title];
    }

     return $_SESSION[$type][] = ['title' => $title, 'desc' => $desc];
  }
}