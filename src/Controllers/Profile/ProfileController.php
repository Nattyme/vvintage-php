<?php
declare(strict_types=1);

namespace Vvintage\Controllers\Profile;

use Vvintage\Routing\RouteData;

use Vvintage\Models\User\User;
use Vvintage\Models\Address\Address;


use Vvintage\Services\Auth\SessionManager;
use Vvintage\Services\Messages\FlashMessage;
// use Vvintage\Models\Orders\Orders;


final class ProfileController 
{  
  private SessionManager $sessionManager;
  private FlashMessage $notes;

  public function __construct(SessionManager $sessionManager, FlashMessage $notes)
  {
    $this->sessionManager = $sessionManager;
    $this->notes = $notes;
  }

  private function renderProfile(RouteData $routeData)
  {
    require ROOT . 'modules/profile/profile.php';
  }

  public function index(RouteData $routeData)
  {
    $this->renderProfile($routeData);
  }
}