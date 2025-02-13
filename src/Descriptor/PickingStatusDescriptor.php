<?php

namespace App\Descriptor;

class PickingStatusDescriptor {

    public const OPEN = 'O';
    public const COMPLETED = 'C';

    public static function getStatusList() {
        return array(
            'Open' => PickingStatusDescriptor::OPEN,
            'Completed' => PickingStatusDescriptor::COMPLETED
        );
    }

    public static function getDescriptor($type) {
        $types = self::getStatusList();
        foreach ($types as $t => $key) {
            if($key == $type) {
                return $t;
            }
        }
    }
}