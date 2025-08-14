<?php
declare(strict_types=1);

namespace Vvintage\Services\Base;

use Vvintage\Services\Messages\FlashMessage;
use Vvintage\Config\LanguageConfig;


abstract class BaseService
{    
  protected string $currentLang;
  protected FlashMessage $note;

  public function __construct()
  {
    $this->currentLang = LanguageConfig::getCurrentLocale();
    $this->note= new FlashMessage ();
  }

}