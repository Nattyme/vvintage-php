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

    public static function getAvailableLanguages(): array
    {
        return self::LANGUAGES;
    }

    public static function isSupported(string $lang): bool
    {
        return array_key_exists($lang, self::LANGUAGES);
    }

    public static function getDefault(): string
    {
        return self::DEFAULT_LANG;
    }
}
