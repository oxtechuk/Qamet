<?php

namespace App\Traits;

trait HasBilingualFields
{
    public function getAttribute($key)
    {
        if (is_string($key)) {
            if (str_ends_with($key, '_ar')) {
                $field = substr($key, 0, -3);
                if (in_array($field, $this->translatable ?? [])) {
                    return $this->getTranslation($field, 'ar');
                }
            }
            if (str_ends_with($key, '_en')) {
                $field = substr($key, 0, -3);
                if (in_array($field, $this->translatable ?? [])) {
                    return $this->getTranslation($field, 'en');
                }
            }
        }

        $value = parent::getAttribute($key);

        if (is_array($value) && is_string($key) && in_array($key, $this->translatable ?? [])) {
            $locale = app()->getLocale();

            return $value[$locale] ?? $value['ar'] ?? $value['en'] ?? (reset($value) ?: '');
        }

        return $value;
    }

    public function fill(array $attributes)
    {
        foreach ($attributes as $key => $value) {
            if (str_ends_with($key, '_ar') && in_array(substr($key, 0, -3), $this->translatable ?? [])) {
                $this->setTranslation(substr($key, 0, -3), 'ar', $value ?? '');
                unset($attributes[$key]);
            }
            if (str_ends_with($key, '_en') && in_array(substr($key, 0, -3), $this->translatable ?? [])) {
                $this->setTranslation(substr($key, 0, -3), 'en', $value ?? '');
                unset($attributes[$key]);
            }
        }

        return parent::fill($attributes);
    }

    public function attributesToArray()
    {
        $attributes = parent::attributesToArray();

        foreach ($this->translatable ?? [] as $field) {
            $localeAr = $this->getTranslation($field, 'ar', false);
            $localeEn = $this->getTranslation($field, 'en', false);

            if (is_string($localeAr)) {
                $attributes[$field.'_ar'] = $localeAr;
            }

            if (is_string($localeEn)) {
                $attributes[$field.'_en'] = $localeEn;
            }
        }

        return $attributes;
    }
}
