<?php

require('../../../config.php');
require('../../../vendor/autoload.php');

use App\Model\User;
use App\Controller\Response;

if (empty($_POST['user']))
    Response::error('Preencha o campo "Usuário".');

if (empty($_POST['password']))
    Response::error('Preencha o campo "Senha".');

$user = new User;

if ($user->login($_POST['user'], $_POST['password']))
    Response::success('ok');

Response::error('Erro inesperado.');