<?php

namespace App\Controller;

use App\Model\Route as model;

class Route {

    private model $model;
    private array $parameters;
    private object $controller;
    private string $method;

    public bool $valid_access;

    public function __construct()
    {
        $this->model = new model;
        $this->valid_access = $this->validateAccess();
    }

    public function getUri(): array
    {
        $uri = $_SERVER['REQUEST_URI'] ?? '';
        $c_uri = ltrim(trim($uri), '/');
        $ret = !empty($c_uri) ? $c_uri : 'login';

        return explode('/', $ret);
    }

    public function callMethod(): mixed
    {
        return $this->controller->{$this->method}(...$this->parameters);
    }

    private function validateController(string $controller): bool
    {
        return class_exists('\App\Controller\\' . ucfirst($controller));
    }

    private function validateMethod(string $controller, string $method): bool
    {
        return method_exists('\App\Controller\\' . ucfirst($controller), $method);
    }

    private function validateAccess(): bool
    {
        $uri = $this->getUri();
        $data = $this->model->validateAccess($uri);

        if (!$data['status']) {

            if (!$this->aliasRoute($data['controller'], $data['method']))
                return false;

            $valid_alias = $this->model->validateAccess([$data['controller'], $data['method']]);

            if (!$valid_alias['status'])
                return false;
        }

        $v_controller = $this->validateController($data['controller']);
        $v_method = $this->validateMethod($data['controller'], $data['method']);

        if (!$v_controller || !$v_method)
            return false;

        $this->controller = new ('\App\Controller\\' . ucfirst($data['controller']));
        $this->method = $data['method'];
        $this->parameters = array_slice($uri, 2);

        return true;
    }

    private function aliasRoute(string &$controller, string &$method): bool
    {
        $key = $controller . '-' . $method;
        $res = match($key) {
            'login-index' => ['user', 'login'],
            default => false
        };

        $v_controller = $this->validateController($res[0]);
        $v_method = $this->validateMethod($res[0], $res[1]);

        if ($res !== false && (!$v_controller || !$v_method))
            return false;

        $controller = $res[0];
        $method = $res[1];

        return is_array($res);
    }

}