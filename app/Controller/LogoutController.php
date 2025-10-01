<?php

namespace App\Controller;

class LogoutController extends AbstractController
{
    public function index(array $requestData): void
    {
        session_start();
        session_destroy();
        header("Location: /");
        die;
    }
}

