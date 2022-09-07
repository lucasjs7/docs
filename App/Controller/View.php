<?php

namespace App\Controller;

class View {

    public static function getFile(string $path, array $data = [])
    {
        $path = str_replace('App/View/', '', $path);
        $path = str_replace('.phtml', '', $path);
        $path .= '.phtml';

        if (!empty($path) && file_exists('App/View/' . $path))
            require('App/View/' . $path);
    }

}