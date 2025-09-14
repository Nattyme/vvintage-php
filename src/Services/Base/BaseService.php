<?php
declare(strict_types=1);

namespace Vvintage\Services\Base;

use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Locale\LocaleService;


abstract class BaseService
{    
  protected string $locale;
  protected FlashMessage $flash;

  public function __construct()
  {
    $this->locale = $locale->getCurrentLocale();
    $this->flash = new FlashMessage ();
  }

}