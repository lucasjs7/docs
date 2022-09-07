<?php

namespace App\Model;

use App\Controller\{Connection, Response};

class User {

    private $con;

    public function __construct()
    {
        $this->con = Connection::getPDO();
    }

    public function login(string $user, string $password): bool
    {
        $connection = Connection::getPDO();
        $sql = $connection->prepare('SELECT id, name, email, password FROM users WHERE email = ? LIMIT 1 ');

        if (!$sql->execute([$user]))
            Response::error('Erro inesperado.');

        if ($sql->rowCount() == 0)
            Response::error('Usuário não encontrado.');

        $line = $sql->fetch();

        if (!password_verify($password, $line['password']))
            Response::error('Senha inválida.');

        setcookie('user_id', $line['id'], (time()+(60*60*24*365)), '/', $_SERVER['SERVER_NAME'], false);
        setcookie('user_name', $line['name'], (time()+(60*60*24*365)), '/', $_SERVER['SERVER_NAME'], false);
        setcookie('user_email', $line['email'], (time()+(60*60*24*365)), '/', $_SERVER['SERVER_NAME'], false);

        return true;
    }

}