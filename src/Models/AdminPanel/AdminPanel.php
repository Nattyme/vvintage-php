<?php
declare(strict_types=1);

namespace Vvintage\Models\AdminPanel;

final class AdminPanel
{
  private int $messagesCount;
  private int $ordersCount;
  private int $commentsCount;
  public function __construct($messagesCount, $ordersCount,$commentsCount)
  {
    $this->messagesCount = $messagesCount;
    $this->ordersCount = $ordersCount;
    $this->commentsCount = $commentsCount;
  }

  public function index () 
  {
    $this->render();
  }

  private function render()
  {
      // ob_start();
      include __DIR__ . '/../templates/admin_panel.php';
      // return ob_get_clean();
    
  }
}





