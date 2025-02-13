<?php

namespace App\Descriptor;

class OrderStatusDescriptor extends StandardDescriptor {

    public const ORDER_RECEIVED = 'R';
    public const ORDER_CANCELED = 'C';
    public const ORDER_PROCESSING = 'P';
    public const ORDER_READY_TO_SHIP = 'T';
    public const ORDER_SHIPPED = 'S';

    public static function getStatusList(): array {
        return array(
            'Order received' => OrderStatusDescriptor::ORDER_RECEIVED,
            'Order canceled' => OrderStatusDescriptor::ORDER_CANCELED,
            'Processing' => OrderStatusDescriptor::ORDER_PROCESSING,
            'Ready to ship' => OrderStatusDescriptor::ORDER_READY_TO_SHIP,
            'Order shipped' => OrderStatusDescriptor::ORDER_SHIPPED
        );
    }
}