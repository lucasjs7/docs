<?php

require('../../../config.php');
require('../../../vendor/autoload.php');

use App\Model\User;
use App\Controller\Response;

if (empty($_POST['id']))
    Response::error('Formulário inválido');

if (empty($_POST['user']))
    Response::error('Preencha o campo "Nome".');

if (strlen($_POST['user']) < 3)
    Response::error('O campo "Nome" deve ter mais de duas letras.');

if (empty($_POST['email']))
    Response::error('Preencha o campo "E-mail".');

if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL))
    Response::error('O campo "E-mail" é inválido.');

if (!empty($_POST['password']) && strlen($_POST['password']) < 8)
    Response::error('O campo "Senha" deve ter mais de sete caracteres.');

$user = new User;

if ($user->update($_POST['id'], $_POST['user'], $_POST['email'], $_POST['password']))
    Response::success('Usuário adicionado.');

Response::error('Erro inesperado.');