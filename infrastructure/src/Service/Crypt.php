<?php 
namespace Infrastructure\Service;


/**
 * Centralizar configurações de cryptografia
 **/
class Crypt {

    public function hash($string, $salt){

        return password_hash($string, PASSWORD_BCRYPT, [
            'cost' => 11,
            'salt' => $salt,
        ]);
    }

} 