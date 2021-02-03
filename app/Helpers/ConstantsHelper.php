<?php

namespace App\Helpers;

class ConstantsHelper {
    const ORDER_STATUS_IN_PROCESS = 'P';
    const ORDER_STATUS_READY = 'L';

    public static function get_order_status_label($status) {
        switch ($status) {
            case self::ORDER_STATUS_IN_PROCESS:
                return 'En Proceso';
                break;
            case self::ORDER_STATUS_READY:
                return 'Listo';
                break;
            default:
                break;
        }
    }
}