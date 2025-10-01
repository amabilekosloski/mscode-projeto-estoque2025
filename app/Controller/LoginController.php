<?php
namespace App\Controller;

use App\Model\Usuario;

class LoginController extends AbstractController
{
    public function index(array $requestData): void
    {
        session_start();

        if (!empty($requestData['email']) && !empty($requestData['senha'])) {
            $model = new Usuario();
            $usuario = $model->buscarPorEmail($requestData['email']);

            if (!$usuario || !password_verify($requestData['senha'], $usuario['senha'])) {
                $_SESSION['erro'] = 'Usuário ou senha inválidos!';
                $this->redirect('/login');
            }

            $_SESSION['usuario_logado'] = true;
            $_SESSION['usuario_email'] = $usuario['email'];
            $this->redirect('/produtos');
        }

        $this->render('usuarios/login.php');
    }
}
