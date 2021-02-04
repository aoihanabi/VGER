<?php

namespace App\Helpers;

class ConstantsHelper {
    const ORDER_STATUS_IN_PROCESS = 'P';
    const ORDER_STATUS_READY = 'L';
    const USER_ADMIN_ROLE = 'admin';
    const USER_EMPLOYEE_ROLE = 'employee';
    const USER_NORMAL_ROLE = 'user';

    /**
     * Returns an array containing all available roles for users.
     * 
     * @return array An array of roles
     *
     * */
    public static function get_user_roles()
    {
        return [self::USER_NORMAL_ROLE => self::get_user_role_label(self::USER_NORMAL_ROLE),
                self::USER_ADMIN_ROLE => self::get_user_role_label(self::USER_ADMIN_ROLE),
                self::USER_EMPLOYEE_ROLE => self::get_user_role_label(self::USER_EMPLOYEE_ROLE)];
    }

    public static function get_user_role_label($role) {
        switch ($role) {
            case self::USER_ADMIN_ROLE:
                return 'Administrador';
            case self::USER_EMPLOYEE_ROLE:
                return 'Empleado';
            case self::USER_NORMAL_ROLE:
                return 'Usuario';
            default:
                return 'Rol de usuario no encontrado.';
        }
    }

    public static function get_order_status_label($status) {
        switch ($status) {
            case self::ORDER_STATUS_IN_PROCESS:
                return 'En Proceso';
                break;
            case self::ORDER_STATUS_READY:
                return 'Listo';
                break;
            default:
                return 'Estado de pedido no encontrado.';
        }
    }
}