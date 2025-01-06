<?php

namespace App\Services;

use App\Models\Constant;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;

class ConstantService
{
    private const CACHE_PREFIX = 'constants:';
    private const CACHE_TTL = 3600; // 1 hour in seconds

    /**
     * Get a constant by its ID
     */
    public static function getById(int $id): ?Constant
    {
        $cacheKey = self::CACHE_PREFIX . "id:{$id}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($id) {
            return Constant::find($id);
        });
    }

    /**
     * Get constants by module
     */
    public static function getByModule(string $module): Collection
    {
        $cacheKey = self::CACHE_PREFIX . "module:{$module}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($module) {
            return Constant::where('module', $module)->get();
        });
    }

    /**
     * Get constants by field within a specific module
     */
    public static function getByModuleAndField(string $module, string $field): Collection
    {
        $cacheKey = self::CACHE_PREFIX . "module:{$module}:field:{$field}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($module, $field) {
            return Constant::where('module', $module)
                ->where('field', $field)
                ->get();
        });
    }

    /**
     * Get constants by field
     */
    public static function getByField(string $field): Collection
    {
        $cacheKey = self::CACHE_PREFIX . "field:{$field}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($field) {
            return Constant::where('field', $field)->get();
        });
    }

    /**
     * Get constant by constant_name
     */
    public static function getByConstantName(string $constantName): ?Constant
    {
        $cacheKey = self::CACHE_PREFIX . "name:{$constantName}";

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($constantName) {
            return Constant::where('constant_name', $constantName)->first();
        });
    }

    /**
     * Search constants with multiple criteria
     */
    public static function search(array $criteria): Collection
    {
        $cacheKey = self::CACHE_PREFIX . "search:" . md5(json_encode($criteria));

        return Cache::remember($cacheKey, self::CACHE_TTL, function () use ($criteria) {
            $query = Constant::query();

            if (isset($criteria['module'])) {
                $query->where('module', $criteria['module']);
            }

            if (isset($criteria['field'])) {
                $query->where('field', $criteria['field']);
            }

            if (isset($criteria['constant_name'])) {
                $query->where('constant_name', 'LIKE', "%{$criteria['constant_name']}%");
            }

            if (isset($criteria['name'])) {
                $query->where(function ($q) use ($criteria) {
                    $q->where('name_en', 'LIKE', "%{$criteria['name']}%")
                        ->orWhere('name_ar', 'LIKE', "%{$criteria['name']}%");
                });
            }

            if (isset($criteria['value'])) {
                $query->where('value', $criteria['value']);
            }

            return $query->get();
        });
    }

    /**
     * Get localized name based on locale
     */
    public static function getLocalizedName(int $id, string $locale = null): string
    {
        $constant = self::getById($id);

        if (!$constant) {
            return '';
        }

        $locale = $locale ?? app()->getLocale();
        $fieldName = "name_" . $locale;

        return $constant->{$fieldName} ?? '';
    }

    /**
     * Get value by constant ID
     */
    public static function getValue(int $id): string
    {
        $constant = self::getById($id);
        return $constant ? $constant->value : '';
    }

    /**
     * Clear all related caches for a constant
     */
    public static function clearCache(Constant $constant): void
    {
        Cache::forget(self::CACHE_PREFIX . "id:{$constant->id}");
        Cache::forget(self::CACHE_PREFIX . "module:{$constant->module}");
        Cache::forget(self::CACHE_PREFIX . "field:{$constant->field}");
        Cache::forget(self::CACHE_PREFIX . "module:{$constant->module}:field:{$constant->field}");

        if ($constant->constant_name) {
            Cache::forget(self::CACHE_PREFIX . "name:{$constant->constant_name}");
        }
    }
}
