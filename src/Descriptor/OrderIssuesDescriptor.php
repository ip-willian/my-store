<?php

namespace App\Descriptor;

class OrderIssuesDescriptor extends StandardDescriptor {

    public const ITEM_MISSING = 'M';
    public const ITEM_DAMAGED = 'C';
    public const ITEMS_MISMATCHED = 'T';

    public static function getStatusList(): array {
        return array(
            'Item is missing' => OrderIssuesDescriptor::ITEM_MISSING,
            'Item is damaged' => OrderIssuesDescriptor::ITEM_DAMAGED,
            'Items mismatched' => OrderIssuesDescriptor::ITEMS_MISMATCHED
        );
    }


}