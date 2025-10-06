<?php
declare(strict_types=1);

namespace Vvintage\Services\Locale;

use Locale;
use Vvintage\Config\LanguageConfig;

final class LocaleService
{
    private string $currentLang;
    private string $currentLocale;

    private const DATE_PATTERNS = [
        'ru' => "d MMMM y 'в' HH:mm",
        'en' => "MMMM d, y 'at' HH:mm",
        'de' => "d. MMMM y 'um' HH:mm",
        'es' => "d 'de' MMMM 'de' y 'a las' HH:mm",
        'fr' => "d MMMM y 'à' HH:mm",
        'ja' => "y年M月d日 HH:mm",
        'zh' => "y年M月d日 HH:mm",
    ];

    public function __construct()
    {
        $this->currentLang = $_SESSION['locale'] ?? LanguageConfig::getDefaultLang();

        if (!array_key_exists($this->currentLang, LanguageConfig::getAvailableLanguages())) {
            $this->currentLang = LanguageConfig::getDefaultLang();
        }

        $this->currentLocale = $this->buildLocale($this->currentLang);
    }

    public function getCurrentLang(): string
    {
        return $this->currentLang;
    }

    public function getCurrentLocale(): string
    {
        return $this->currentLocale;
    }

    public function getDefaultLang(): string
    {
        return LanguageConfig::getDefault();
    }

    public function getDefaultLocale(): string
    {
        return $this->buildLocale($this->getDefaultLang());
    }

    public function setCurrentLang(string $lang): void
    {
        if (array_key_exists($lang, LanguageConfig::getAvailableLanguages())) {
            $_SESSION['locale'] = $lang;
            $this->currentLang = $lang;
            $this->currentLocale = $this->buildLocale($lang);
        }
    }

    private function buildLocale(string $lang): string
    {
        if (isset(LanguageConfig::SPECIAL_LOCALES[$lang])) {
            return LanguageConfig::SPECIAL_LOCALES[$lang];
        }

        return Locale::composeLocale([
            'language' => $lang,
            'region' => strtoupper($lang),
        ]);
    }

    // 🔹 Форматирование даты с учетом локали
    public function formatDateTime(\DateTimeInterface $dateTime): string
    {
        $langCode = substr($this->currentLocale, 0, 2);
        $pattern = self::DATE_PATTERNS[$langCode] ?? "d MMMM y HH:mm";

        $formatter = new \IntlDateFormatter(
            $this->currentLocale,
            \IntlDateFormatter::LONG,
            \IntlDateFormatter::SHORT,
            date_default_timezone_get(),
            \IntlDateFormatter::GREGORIAN,
            $pattern
        );

        return $formatter->format($dateTime);
    }
}

