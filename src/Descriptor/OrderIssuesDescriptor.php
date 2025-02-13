<?php

namespace App\Descriptor;

class OrderIssuesDescriptor {

    public const ITEM_MISSING = 'M';
    public const ITEM_DAMAGED = 'C';
    public const ITEMS_MISMATCHED = 'T';

    public static function getStatusList() {
        return array(
            'Item is missing' => OrderIssuesDescriptor::ITEM_MISSING,
            'Item is damaged' => OrderIssuesDescriptor::ITEM_DAMAGED,
            'Items mismatched' => OrderIssuesDescriptor::ITEMS_MISMATCHED
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