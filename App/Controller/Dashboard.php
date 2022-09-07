<?php

namespace App\Controller;

class Dashboard {

    public function __construct()
    {

    }

    public function index()
    {
        $data['view'] = 'Body';
        $data['content'] = 'dashboard/index';

        return $data;
    }

}