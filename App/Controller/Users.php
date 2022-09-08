<?php

namespace App\Controller;

use App\Model\User;

class Users {

    private User $model;

    public function __construct()
    {
        $this->model = new User;
    }

    public function index()
    {
        $data['view'] = 'Body';
        $data['content'] = 'user/index';
        $data['list'] = $this->model->getList();

        return $data;
    }

    public function login()
    {
        $data['view'] = 'user/login';

        return $data;
    }

    public function new()
    {
        $data['view'] = 'Body';
        $data['content'] = 'user/new';

        return $data;
    }

    public function edit(int $id)
    {
        $user = $this->model->getUser($id);

        if ($user === false)
            header('Location: /users');

        $data['view'] = 'Body';
        $data['content'] = 'user/edit';
        $data['line'] = $user;

        return $data;
    }

}