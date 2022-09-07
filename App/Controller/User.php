<?php

namespace App\Controller;

class User {

    public function login()
    {
        $data['view'] = 'user/login';

        return $data;
    }

}