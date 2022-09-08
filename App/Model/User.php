<?php

namespace App\Model;

use App\Controller\{Connection, Response};
use App\Controller\View;

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

    public function getUser(int|string $val)
    {
        $col = is_int($val) ? 'id' : 'email';

        $connection = Connection::getPDO();
        $sql = $connection->prepare("SELECT * FROM users WHERE {$col} = ? LIMIT 1 ");
        $sql->execute([$val]);

        $exists = $sql->rowCount() > 0;

        return $exists ? $sql->fetch(\PDO::FETCH_ASSOC) : false;
    }

    public function store(string $name, string $email, string $password)
    {
        $connection = Connection::getPDO();

        if ($this->getUser($email) !== false)
            Response::error('Esse e-mail já está em uso.');

        $sql = $connection->prepare('INSERT INTO users(name, email, password) VALUES(?,?,?)');

        if (!$sql->execute([$name, $email, password_hash($password, PASSWORD_DEFAULT)]))
            Response::error('Erro inesperado.');

        return true;
    }

    public function update(int $id, string $name, string $email, string $password)
    {
        $user = $this->getUser($email);
        $connection = Connection::getPDO();

        if ($user['id'] != $id)
            Response::error('Esse e-mail já está em uso.');

        if (empty($password)) {
            $col_p = '';
            $content = [$name, $email, $id];
        } else {
            $col_p = ',password=?';
            $content = [$name, $email, password_hash($password, PASSWORD_DEFAULT), $id];
        }

        $sql = $connection->prepare('UPDATE users SET name=?, email=? ' .$col_p. ' WHERE id = ? ');

        if (!$sql->execute($content))
            Response::error('Erro inesperado.');

        return true;
    }

    public function getList()
    {
        $sql = $this->con->prepare('SELECT id, name, email FROM users ');
        $sql->execute();

        $data = $sql->fetchAll(\PDO::FETCH_ASSOC);
        $buttons = [
            View::getContent('_includes/buttons/delete', ['class' => 'btn_delete'])
        ];

        foreach($data as &$row) {

            $btn_edit = View::getContent('_includes/buttons/edit', [
                    'attr' => View::getAttr(['href' => '/users/edit/' . $row['id']])
                ]);
            $btns = array_merge([$btn_edit], $buttons);

            $row = [
                'id' => [
                    'content' => "#{$row['id']}",
                    'class'   => 'id text-zinc-400',
                    'attr'    => ['data-id' => $row['id']]
                ],
                'name'    => ['content' => $row['name'],          'class' => 'name'],
                'email'   => ['content' => $row['email'],         'class' => 'email'],
                'buttons' => ['content' => implode('', $btns), 'class' => 'buttons text-right']
            ];
        }

        return $data;
    }

    public function destroy(int $id)
    {
        $sql = $this->con->prepare('DELETE FROM  users WHERE id = ? ');

        return $sql->execute([$id]);
    }

}