<?php
declare(strict_types=1);

namespace Vvintage\Config;

class LanguageConfig
{
    public const LANGUAGES = [
        'ru' => 'Русский',
        'en' => 'English',
        'de' => 'Deutsch',
        'es' => 'Español',
        'fr' => 'Français',
        'ja' => '日本語',
        'zh' => '中文',
    ];

    public const DEFAULT_LANG = 'ru';

    public const SPECIAL_LOCALES = [
      'ja' => 'ja_JP',
      'zh' => 'zh_CN',
    ];

    // public static function getCurrentLang(): string
    // {
    //     $lang = $_SESSION['locale'] ?? self::DEFAULT_LANG;
    //     return self::isSupported($lang) ? $lang : self::DEFAULT_LANG;
    // }

    // // 🔹 Получить локаль (для Intl и форматирования)
    // public static function getCurrentLocale(): string
    // {
    //     $lang = self::getCurrentLang();

    //     if (isset(self::SPECIAL_LOCALES[$lang])) {
    //         return self::SPECIAL_LOCALES[$lang];
    //     }

    //     return Locale::composeLocale([
    //         'language' => $lang,
    //         'region' => strtoupper($lang)
    //     ]);
    // }

    public static function isSupported(string $lang): bool
    {
        return array_key_exists($lang, self::LANGUAGES);
    }


    public static function getAvailableLanguages(): array
    {
        return self::LANGUAGES;
    }

    public static function getDefault(): string
    {
        return self::DEFAULT_LANG;
    }

}
