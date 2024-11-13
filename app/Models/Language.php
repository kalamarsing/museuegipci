<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Cache;
use App;

class Language extends Model
{
    use SoftDeletes;
    
    protected $fillable = ['name', 'iso', 'isDefault'];


    public static function getDefault()
    {
        $key = 'languages.default';
        $language = cache($key);

        if (!isset($language)) {
            $language = self::where('isDefault', 1)->first();

            if (!isset($language)) {
                $language = self::first();
            }

            cache([
                $key => $language,
            ], now()->addSeconds(5 * 60));
        }

        return $language;
    }

    public function save(array $options = [])
    {
        // Remove caches
        Cache::forget('languages.default');
        Cache::forget('languages.all');

        parent::save($options);
    }

    public static function getCurrentLanguage()
    {
        $currentLang = self::getAllCached()->where('iso', App::getLocale())->first();

        return $currentLang ? $currentLang : self::getDefault();
    }

    public static function getCachedLanguageById($languageId)
    {
        return self::getAllCached()->where('id', $languageId)->first();
    }

    public static function getCachedLanguageByIso($iso)
    {
        return self::getAllCached()->where('iso', $iso)->first();
    }

    public static function getAllCached()
    {
        $key = 'languages.all';
        $languages = cache($key);

        if (!isset($languages)) {
            $languages = self::all();

            Cache::forever($key,$languages);
        }

        return $languages;
    }

}

