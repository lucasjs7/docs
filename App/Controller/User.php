<?php

namespace App\Controller;

class User {

    public function login()
    {
        $data['title'] = '<h1>Página de Login</h1>';
        $data['view'] = 'user/login.phtml';

        return $data;
    }

}