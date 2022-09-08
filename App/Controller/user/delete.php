<?php

require('../../../config.php');
require('../../../vendor/autoload.php');

use App\Model\User;
use App\Controller\Response;

if (empty($_POST['id']))
    Response::error('Dados inválidos.');

$user = new User;

if ($user->destroy($_POST['id']))
    Response::success('Usuário excluído.');

Response::error('Erro inesperado.');