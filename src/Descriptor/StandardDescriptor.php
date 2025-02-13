<?php

namespace App\Descriptor;

abstract class StandardDescriptor
{
    public static function getDescriptor($type)
    {
        $types = static::getStatusList();
        foreach ($types as $t => $key) {
            if ($key === $type) {
                return $t;
            }
        }

        return null;
    }

    abstract public static function getStatusList(): array;
}
