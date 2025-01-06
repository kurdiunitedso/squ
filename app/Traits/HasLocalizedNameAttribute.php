<?php

namespace App\Traits;

trait HasLocalizedNameAttribute
{
    public function getNameLocaleAttribute()
    {
        $locale = app()->getLocale();
        $localizedColumnName = 'name';

        if ($locale == 'ar')
            $localizedColumnName = 'name';
        else if ($locale == 'en' || $locale == 'he')
            $localizedColumnName = 'name_' . $locale;

        return $this->getAttribute($localizedColumnName);
    }
}
