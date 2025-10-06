<?php
declare(strict_types=1);

namespace Vvintage\Services\Base;

use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Services\Locale\LocaleService;
use Vvintage\Config\LanguageConfig;


abstract class BaseService
{    
  public string $currentLang;
  public string $defaultLocale;
  public array $languages;
  protected FlashMessage $flash;
  protected LocaleService $localeService;

  public function __construct()
  {
    $this->localeService = new LocaleService();
    $this->currentLang = $this->localeService->getCurrentLang();
    $this->flash = new FlashMessage ();
    $this->defaultLocale = $this->localeService->getDefaultLocale();
    $this->languages = LanguageConfig::getAvailableLanguages();
  }

}