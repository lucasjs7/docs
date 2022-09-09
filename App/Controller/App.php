<?php

namespace App\Controller;

class App {

    private Route $route;

    public function __construct()
    {
        $this->route = new Route;

        $this->validateAccess();
        $this->view();
    }

    private function view()
    {
        define('PG_TITLE', $this->route->title);
        $data = $this->route->callMethod();

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $data['response']['status'] = 200;

            exit(json_encode($data['response']));
        }

        View::getFile('App', $data);
    }

    private function validateAccess(): void
    {
        if ($this->route->valid_access)
            return;

        switch ($_SERVER['REQUEST_METHOD']) {
            case 'POST':
                exit(json_encode([
                    'error' => 'Acesso negado.',
                    'status' => '403'
                ]));
            default:
                header('Location: /login');
                break;
        }
    }

}