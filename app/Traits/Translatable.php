<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait Translatable
{
    /**
     * Récupère une traduction pour un attribut donné.
     *
     * @param string $key
     * @param string|null $locale
     * @return mixed
     */
    public function getTranslation(string $key, ?string $locale = null)
    {
        $locale = $locale ?? App::getLocale();
        $translationKey = $key . '_translations';

        // Si la colonne de traduction existe
        if (isset($this->attributes[$translationKey])) {
            $translations = json_decode($this->attributes[$translationKey], true);

            // Retourner la traduction si elle existe
            if (isset($translations[$locale])) {
                return $translations[$locale];
            }
        }

        // Retourner la valeur par défaut si pas de traduction
        return $this->attributes[$key] ?? null;
    }

    /**
     * Définit une traduction pour un attribut donné.
     *
     * @param string $key
     * @param string $value
     * @param string|null $locale
     * @return self
     */
    public function setTranslation(string $key, string $value, ?string $locale = null): self
    {
        $locale = $locale ?? App::getLocale();
        $translationKey = $key . '_translations';

        $translations = isset($this->attributes[$translationKey])
            ? json_decode($this->attributes[$translationKey], true)
            : [];

        $translations[$locale] = $value;
        $this->attributes[$translationKey] = json_encode($translations);

        return $this;
    }

    /**
     * Récupère un attribut avec sa traduction automatique.
     *
     * @param string $key
     * @return mixed
     */
    public function getAttribute($key)
    {
        // Si l'attribut est traduisible, retourner la traduction
        if (property_exists($this, 'translatable') && in_array($key, $this->translatable)) {
            return $this->getTranslation($key);
        }

        return parent::getAttribute($key);
    }

    /**
     * Définit un attribut avec sa traduction automatique.
     *
     * @param string $key
     * @param mixed $value
     * @return mixed
     */
    public function setAttribute($key, $value)
    {
        // Si l'attribut est traduisible et que c'est une chaîne
        if (property_exists($this, 'translatable') && in_array($key, $this->translatable) && is_string($value)) {
            $this->attributes[$key] = $value;
            return $this->setTranslation($key, $value);
        }

        return parent::setAttribute($key, $value);
    }

    /**
     * Récupère toutes les traductions pour un attribut.
     *
     * @param string $key
     * @return array
     */
    public function getAllTranslations(string $key): array
    {
        $translationKey = $key . '_translations';

        if (isset($this->attributes[$translationKey])) {
            return json_decode($this->attributes[$translationKey], true) ?? [];
        }

        return [];
    }

    /**
     * Vérifie si une traduction existe pour un attribut et une locale.
     *
     * @param string $key
     * @param string|null $locale
     * @return bool
     */
    public function hasTranslation(string $key, ?string $locale = null): bool
    {
        $locale = $locale ?? App::getLocale();
        $translations = $this->getAllTranslations($key);

        return isset($translations[$locale]);
    }
}
