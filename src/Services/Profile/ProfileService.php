<?php 
declare(strict_types=1);

namespace Vvintage\Services\Profile;

final class ProfileService 
{
  public function __construct(
    private ProfileService $profileService
  )
  {}
}
