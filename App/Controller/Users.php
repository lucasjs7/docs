<?php

namespace App\Controller;

class Users {

    public function login()
    {
        $data['view'] = 'user/login';

        return $data;
    }

}