<?php

namespace App\Controller;

class AppController extends AbstractController
{
    public function index(array $requestData): void
    {
        $this->render('usuarios/login.php');
    }
}