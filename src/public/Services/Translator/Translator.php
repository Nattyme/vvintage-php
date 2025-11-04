<?php 
declare(strict_types=1);

namespace Vvintage\Services\Translator;

use Symfony\Component\Translation\Translator as SymfonyTranslator;
use Symfony\Component\Translation\Loader\ArrayLoader;

final class Translator 
{
  private SymfonyTranslator $translator;

  public function __construct(string $locale = 'ru')
  {
    $this->translator = new SymfonyTranslator($locale);
    $this->translator->addLoader('array', new ArrayLoader());

    // Загружаем переводы из файлов
    $this->loadTranslations($locale);
  }

  /** 
   * Метод загружает нужный файл с переводом
   */
  private function loadTranslations(string $locale): void
  {
    $langPath = ROOT . 'src/Lang' . DIRECTORY_SEPARATOR  . $locale; 

    // Выбираем все файлы .php в папке текущего lang
    $files = glob($langPath . '/*.php');
    // $files = ['buttons.php', 'messages.php', 'navigation.php', 'validation.php'];


    foreach($files as $filePath) {
   
      $translations = require $filePath;
      $domain = pathinfo($filePath, PATHINFO_FILENAME); // например 'messages'
      $this->translator->addResource('array', $translations, $locale, $domain);
    }
    // foreach($files as $file) {
    //   // Для каждого файла задаем путь
    //   $translations = require $langPath . '/' . $file;

    //   $domain = pathinfo($file, PATHINFO_FILENAME); // Название файла без .php: messages, navigation, validation.
    //   $this->translator->addResource('array', $translations, $locale, $domain);
    // }
  }

  public function trans(string $key, array $params = [], string $domain = 'messages'): string
  {
    // $translation->trans('login.success'); // => 'Вы успешно вошли!'
    return $this->translator->trans($key, $params, $domain);
  }

  public function setLocale(string $locale): void
  {
      $this->translator->setLocale($locale);
      $this->loadTranslations($locale);
  }

  public function getTranslator(): SymfonyTranslator
  {
      return $this->translator;
  }


}

// Пример использования
// $translator = new Translation('fr');

// echo $translator->trans('login.success'); // подключает из fr/messages.php
// echo $translator->trans('nav.home', [], 'navigation'); // из fr/navigation.php
