<?php

namespace App\Descriptor;

class PickingStatusDescriptor extends StandardDescriptor {

    public const OPEN = 'O';
    public const COMPLETED = 'C';

    public static function getStatusList(): array {
        return array(
            'Open' => PickingStatusDescriptor::OPEN,
            'Completed' => PickingStatusDescriptor::COMPLETED
        );
    }

}