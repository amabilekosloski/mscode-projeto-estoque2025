<?php

namespace App\Controller;

abstract class AbstractController
{
    public function render(string $viewName, array $data = []): void
    {
        extract($data);

        $viewFile = __DIR__ . '/../../public/view/' . $viewName;

        if (!file_exists($viewFile)) {
            die("View {$viewName} não encontrada!");
        }

        require $viewFile;
    }

    public function redirect(string $route): never
    {
        header("Location: {$route}");
        die();
    }

    public function redirectToError(string $mensagemErro): never
    {
        header("Location: /error?mensagem=" . urlencode($mensagemErro));
        die();
    }

    abstract public function index(array $requestData): void;
}