<?php
declare(strict_types=1);

namespace Vvintage\Services\Locale;

use Locale;
use Vvintage\Config\LanguageConfig;

final class LocaleService
{
    private string $currentLang;
    private string $currentLocale;

    public function __construct()
    {
        // Берём текущий язык из сессии или используем дефолтный
        $this->currentLang = $_SESSION['locale'] ?? LanguageConfig::getDefaultLang();

        // Проверяем, поддерживается ли язык
        if (!array_key_exists($this->currentLang, LanguageConfig::getAvailableLanguages())) {
            $this->currentLang = LanguageConfig::getDefaultLang();
        }

        // Генерируем локаль
        $this->currentLocale = $this->buildLocale($this->currentLang);
    }

    // 🔹 Возвращает язык ('ru', 'en', ...)
    public function getCurrentLang(): string
    {
        return $this->currentLang;
    }

    // 🔹 Возвращает локаль ('ru_RU', 'en_US', ...)
    public function getCurrentLocale(): string
    {
        return $this->currentLocale;
    }

    // 🔹 Возвращает язык по умолчанию
    public function getDefaultLang(): string
    {
        return LanguageConfig::getDefault();
    }

    // 🔹 Возвращает локаль по умолчанию
    public function getDefaultLocale(): string
    {
        return $this->buildLocale($this->getDefaultLang());
    }

    // 🔹 Меняет язык (например, если пользователь переключил)
    public function setCurrentLang(string $lang): void
    {
        if (array_key_exists($lang, LanguageConfig::getAvailableLanguages())) {
            $_SESSION['locale'] = $lang;
            $this->currentLang = $lang;
            $this->currentLocale = $this->buildLocale($lang);
        }
    }

    // 🔹 Вспомогательный метод для построения локали
    private function buildLocale(string $lang): string
    {
        // Если язык в исключениях — возвращаем его
        if (isset(LanguageConfig::SPECIAL_LOCALES[$lang])) {
            return LanguageConfig::SPECIAL_LOCALES[$lang];
        }

        // Иначе создаём локаль автоматически
        return Locale::composeLocale([
            'language' => $lang,
            'region' => strtoupper($lang),
        ]);
    }
}
