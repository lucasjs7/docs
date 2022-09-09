<?php

namespace App\Controller;

use App\Model\User;
use App\Controller\Response;

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

    public function store()
    {
        if (empty($_POST['user']))
            Response::error('Preencha o campo "Nome".');

        if (strlen($_POST['user']) < 3)
            Response::error('O campo "Nome" deve ter mais de duas letras.');

        if (empty($_POST['email']))
            Response::error('Preencha o campo "E-mail".');

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            Response::error('O campo "E-mail" é inválido.');

        if (empty($_POST['password']))
            Response::error('Preencha o campo "Senha".');

        if (strlen($_POST['password']) < 8)
            Response::error('O campo "Senha" deve ter mais de sete caracteres.');

        $user = new User;

        if ($user->store($_POST['user'], $_POST['email'], $_POST['password']))
            Response::success('Usuário adicionado.');

        Response::error('Erro inesperado.');
    }

    public function access()
    {
        if (empty($_POST['user']))
            Response::error('Preencha o campo "Usuário".');

        if (empty($_POST['password']))
            Response::error('Preencha o campo "Senha".');

        $user = new User;

        if ($user->login($_POST['user'], $_POST['password']))
            Response::success('ok');

        Response::error('Erro inesperado.');
    }

    public function update()
    {
        if (empty($_POST['id']))
            Response::error('Formulário inválido');

        if (empty($_POST['user']))
            Response::error('Preencha o campo "Nome".');

        if (strlen($_POST['user']) < 3)
            Response::error('O campo "Nome" deve ter mais de duas letras.');

        if (empty($_POST['email']))
            Response::error('Preencha o campo "E-mail".');

        if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
            Response::error('O campo "E-mail" é inválido.');

        if (!empty($_POST['password']) && strlen($_POST['password']) < 8)
            Response::error('O campo "Senha" deve ter mais de sete caracteres.');

        $user = new User;

        if ($user->update($_POST['id'], $_POST['user'], $_POST['email'], $_POST['password']))
            Response::success('Usuário adicionado.');

        Response::error('Erro inesperado.');
    }

    public function delete()
    {
        if (empty($_POST['id']))
            Response::error('Dados inválidos.');

        $user = new User;

        if ($user->destroy($_POST['id']))
            Response::success('Usuário excluído.');

        Response::error('Erro inesperado.');
    }

}