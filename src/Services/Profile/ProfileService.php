<?php 
declare(strict_types=1);

namespace Vvintage\Services\Profile;
use Vvintage\Services\Base\BaseService;

class ProfileService extends BaseService
{
  private ProfileService $profileService;

  public function __construct()
  {
    parent::__construct();
    $this->service = new ProfileService();
  }
}
