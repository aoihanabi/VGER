<?php
if (!function_exists('user_roles')) {
    /**
     * Returns an array containing all available roles for users.
     * 
     * @return array An array of roles
     *
     * */
    function user_roles()
    {
        return ['user' => 'Usuario', 'admin' => 'Administrador', 'employee' => 'Empleado']; 
    }
}