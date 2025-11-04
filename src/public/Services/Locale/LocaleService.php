<?php
declare(strict_types=1);

namespace Vvintage\Services\Locale;

use Locale;
use Vvintage\Config\LanguageConfig;
use Vvintage\Services\Session\SessionService;

final class LocaleService
{
    private SessionService $sessionService;
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
        $this->sessionService = new SessionService();
        $this->currentLang = $this->sessionService->getCurrentLocale() ?? LanguageConfig::getDefault();

        if (!array_key_exists($this->currentLang, LanguageConfig::getAvailableLanguages())) {
            $this->currentLang = LanguageConfig::getDefault();
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
            $this->sessionService->setCurrentLocale($lang);
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

    // Форматирование даты с учетом локали
    public function formatDateTime(string|\DateTimeInterface $dateTime): string
    {
        if(is_string($dateTime)) {
          // Проверяем: это timestamp или форматированная дата типа 2025-10-29
          if (ctype_digit($dateTime)) {
            $dateTime = ( new \Datetime() )->setTimestamp((int)$dateTime);
          } else {
            $dateTime = new \DateTime($dateTime);
          }
        }
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

    public function formatIsoDateTime(\DateTimeInterface $dateTime): string
    {
        // ISO 8601 формат для HTML <time datetime="...">
        return $dateTime->format('c'); // эквивалент ISO 8601 (например, 2025-10-12T18:30:00+03:00)
    }

}

