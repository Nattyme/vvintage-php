<?php
declare(strict_types=1);

namespace Vvintage\Traits;


trait HasTranslations
{
    // НЕ объявляем свойства здесь
    // Они должны быть в классе, который использует этот trait

    public function setLocale(string $locale): void
    {
        $this->currentLocale = $locale;
    }

    public function getLocale(): string
    {
        return $this->currentLocale ?? 'ru';
    }

    public function getTranslation(string $locale = null): ?array
    {
        $locale = $locale ?? $this->getLocale();
        return $this->translations[$locale] ?? null;
    }

    public function getTranslatedTitle(): string
    {
        return $this->getTranslation()['title'] ?? ($this->title ?? '');
    }

    public function getTranslatedDescription(): string
    {
        return $this->getTranslation()['description'] ?? '';
    }

    public function getMetaTitle(): string
    {
        return $this->getTranslation()['meta_title'] ?? '';
    }

    public function getMetaDescription(): string
    {
        return $this->getTranslation()['meta_description'] ?? '';
    }
}

