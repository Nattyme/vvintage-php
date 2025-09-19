<?php
declare(strict_types=1);

namespace Vvintage\Services\Base;

use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Locale\LocaleService;


abstract class BaseService
{    
  protected string $locale;
  protected string $defaultLocale;
  protected FlashMessage $flash;
  protected LocaleService $localeService;

  public function __construct()
  {
    $this->localeService = new LocaleService();
    $this->locale = $this->localeService->getCurrentLocale();
    $this->flash = new FlashMessage ();
    $this->defaultLocale = $this->localeService->getDefaultLocale();
  }

}