<?php
declare(strict_types=1);

namespace Vvintage\Services\Base;

use Vvintage\Services\Locale\LocaleService;
use Vvintage\Config\LanguageConfig;

//!!  TODO:remove this class and use LocaleService as DI instead
abstract class BaseService
{    
  public string $currentLang;
  public string $defaultLocale;
  public array $languages;
  protected LocaleService $localeService;

  public function __construct()
  {
    $this->localeService = new LocaleService();
    $this->currentLang = $this->localeService->getCurrentLang();
    $this->defaultLocale = $this->localeService->getDefaultLocale();
    $this->languages = LanguageConfig::getAvailableLanguages();
  }

  

}