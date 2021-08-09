<?php


namespace App\Permission;


use App\Modules\Profile\Permission\ProfilePermission;
use BenSampo\Enum\Enum;
use Illuminate\Support\Collection;
use Throwable;

/**
 * Class AbstractPermission
 * @package App\Authorization\Permission
 */
abstract class AbstractPermission extends Enum
{
    static array $classes = [];

    /**
     * @param string $class
     * @throws Throwable
     */
    public static function register(string $class): void
    {
        throw_unless(is_subclass_of($class, self::class), "{$class} must be an instance of ".self::class);
        self::$classes[] = $class;
    }

    /**
     * @return Collection
     */
    public static function permissions(): Collection
    {
        return collect(static::$classes)
        ->map(fn ($class) => $class::getValues())
        ->flatten();
    }
}
