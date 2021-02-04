<?php

if (!function_exists('string_generator')) {
    /**
     * Returns a random string of the given lenght (or 10 if not specified)
     * 
     * @return string A string of random characters
     */
    function string_generator($length = 10) {
        $str = 'abcdef]g123hijkl*mQRSTnopq~r0ABC[DEFGHIJ4-56789stuvwxyzK}LMNOPU#VWXYZ';
        return substr(str_shuffle(str_repeat($str, ceil($length/strlen($str)))), 1, $length);
    }
}

if (!function_exists('send_email')) {
    /**
     * Sends an email to a hardcoded destinatary
     * @param string $body 
     */
    function send_email($title, $body, $receiver) {
        
        $details = [
            'title' => $title,
            'body' => $body #'Nos complace informarle que su pedido fue recibido, se encuentra en proceso y se lo enviaremos en los próximos 2 días'
        ];
        Mail::to($receiver)->send(new \App\Mail\Mailer($details));
    }
}