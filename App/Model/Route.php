<?php

namespace App\Model;

use PDO;
use App\Controller\Connection;

class Route {

    private PDO $connection;

    public function __construct()
    {
        $this->connection = Connection::getPDO();
    }

    private function getController(string $name): int|bool
    {
        $sql = $this->connection->prepare('SELECT id FROM controller WHERE name = ? LIMIT 1');
        $sql->execute([$name]);

        $line = $sql->fetch();

        return $line['id'] ?? false;
    }

    private function getMethod(string $name, int $controller): array|bool
    {
        $sql = $this->connection->prepare('SELECT id, title FROM method WHERE name = ? AND controller = ? LIMIT 1');
        $sql->execute([$name, $controller]);

        $line = $sql->fetch();

        return !empty($line['id']) ? $line : false;
    }

    public function validateAccess(array $params): array
    {
        $ret['status'] = false;
        $ret['controller'] = 'login';
        $ret['method'] = 'index';
        $ret['title'] = '';

        if (empty($params[0]))
            return $ret;

        $controller_id = $this->getController($params[0]);

        if ($controller_id === false)
            return $ret;

        $method = $params[1] ?? 'index';
        $data_method = $this->getMethod($method, $controller_id);
        $ret['status'] = !empty($data_method['id']) && is_int($data_method['id']);

        if ($ret['status']) {
            $ret['controller'] = $params[0];
            $ret['method'] = $method;
            $ret['title'] = $data_method['title'] ?? $ret['title'];
        }

        return $ret;
    }

}