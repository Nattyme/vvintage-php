<?php
declare(strict_types=1);

namespace Vvintage\Services\Locale;

use Vvintage\Config\LanguageConfig;

final class LocaleService
{
    private string $currentLang;

    public function __construct()
    {
        $this->currentLang = LanguageConfig::getCurrentLocale();
    }

    public function getCurrentLocale(): string
    {
        return $this->currentLang;
    }
}
