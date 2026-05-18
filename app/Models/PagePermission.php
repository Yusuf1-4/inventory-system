<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Collection;

class PagePermission extends Model
{
    protected $fillable = ['key', 'label', 'description', 'admin', 'supervisor', 'operator'];

    protected $casts = [
        'admin'      => 'boolean',
        'supervisor' => 'boolean',
        'operator'   => 'boolean',
    ];

    /** Per-request cache so we only query once per request lifecycle. */
    private static ?Collection $cache = null;

    /**
     * Check whether a given role can access a permission key.
     * Admin always returns true regardless of DB value.
     */
    public static function canRole(string $role, string $key): bool
    {
        if ($role === 'admin') {
            return true;
        }

        if (self::$cache === null) {
            self::$cache = self::all()->keyBy('key');
        }

        $perm = self::$cache->get($key);

        return $perm ? (bool) $perm->{$role} : false;
    }

    /** Clear the per-request cache (call after saving changes). */
    public static function clearCache(): void
    {
        self::$cache = null;
    }
}
