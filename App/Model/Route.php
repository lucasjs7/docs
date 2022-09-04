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

    private function getMethod(string $name, int $controller): int|bool
    {
        $sql = $this->connection->prepare('SELECT id FROM method WHERE name = ? AND controller = ? LIMIT 1');
        $sql->execute([$name, $controller]);

        $line = $sql->fetch();

        return $line['id'] ?? false;
    }

    public function validateAccess(array $params): array
    {
        $ret['status'] = false;
        $ret['controller'] = 'login';
        $ret['method'] = 'index';

        if (empty($params[0]))
            return $ret;

        $controller_id = $this->getController($params[0]);

        if ($controller_id === false)
            return $ret;

        $method = $params[1] ?? 'index';
        $method_id = $this->getMethod($method, $controller_id);
        $ret['status'] = is_int($method_id);

        if ($ret['status']) {
            $ret['controller'] = $params[0];
            $ret['method'] = $method;
        }

        return $ret;
    }

}