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

        require('App/View/App.phtml');
    }

    private function validateAccess(): void
    {
        if (!$this->route->valid_access)
            header('Location: /login');
    }

}