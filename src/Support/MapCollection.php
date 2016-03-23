<?php
namespace FewAgency\FluentForm\Support;

use Illuminate\Support\Collection;

/**
 * A collection implementation suitable for storing key-value maps like arrayables, objects etc.
 * The general behaviour is that maps that are earlier in the collection
 * have higher priority than later ones.
 */
class MapCollection extends Collection
{
    /**
     * Pick the value from the first map in this collection
     * that has a value set for the key.
     * @param string $key in dot-notation
     * @param mixed $default value to return if not found
     * @return mixed
     */
    public function firstValue($key, $default = null)
    {
        // Check for the full key in each map first
        // This is needed because pluck() doesn't check for full dot-notation keys before exploding the key
        $map = $this->first(function ($k, $map) use ($key) {
            return $map instanceof \ArrayAccess and isset($map[$key]);
        });
        if ($map) {
            return $map[$key];
        }
        // If full key not found, pluck the first match
        // and fallback to supplied $default if no match found
        return $this->pluck($key)->first(function ($k, $item) {
            return isset($item);
        }, $default);
    }

    /**
     * Pick the value as a boolean from the first match in this collection of maps.
     * @param string $key in dot-notation
     * @param mixed $default value to return if not found
     * @return bool|null
     */
    public function firstBoolean($key, $default = null)
    {
        $value = $this->firstValue($key, $default);

        return isset($value) ? (bool)$value : $value;
    }
}