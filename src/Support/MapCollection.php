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

    /**
     * Add key-value maps into this MapCollection.
     * If a supplied item is not a map but just a string,
     * it will be added to the collection in a map of string=>true items.
     * @param array $maps containing key-value maps or strings
     * @return $this
     */
    public function prependMaps($maps)
    {
        $string_map = [];
        foreach ($maps as $map) {
            if (is_string($map)) {
                //Collect any strings into a map of string=>true items for insertion later
                $string_map[$map] = true;
            } elseif (!empty($map)) {
                //Put any collected strings into a map on the collection, before the current map is inserted
                if (!empty($string_map)) {
                    $this->prepend($string_map);
                    $string_map = [];
                }
                $this->prepend($map);
            }
        }
        //Put any leftover collected strings into a map on the collection
        if (!empty($string_map)) {
            $this->prepend($string_map);
        }

        return $this;
    }
}