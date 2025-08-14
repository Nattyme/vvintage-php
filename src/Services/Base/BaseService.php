<?php
declare(strict_types=1);

namespace Vvintage\Services\Base;

use Vvintage\Services\Messages\FlashMessage;


abstract class BaseService
{    
  private string $currentLang;
  private FlashMessage $note;

  public function __construct()
  {

      $this->note= new FlashMessage ();
  }

}