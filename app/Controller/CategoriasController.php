<?php

namespace App\Controller;

use App\Database\Database;
use PDO;

class CategoriasController extends AbstractController
{
    private PDO $db;

    public function __construct()
    {
        $database = new Database('localhost', 'estoque', 'root', 'password');
        $this->db = $database->connection();
        if(session_status() === PHP_SESSION_NONE) session_start();
    }

    public function index(array $requestData): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($requestData['id'])) {
                $this->update($requestData);
            } else {
                $this->store($requestData);
            }
            return;
        }

        if (isset($requestData['create'])) {
            $this->render('categorias/create.php');
            return;
        }

        if (isset($requestData['edit'])) {
            $this->edit($requestData);
            return;
        }

        if (isset($requestData['delete'])) {
            $this->delete($requestData);
            return;
        }

        $categorias = $this->db->query("SELECT * FROM categoria ORDER BY id")->fetchAll(PDO::FETCH_ASSOC);
        $this->render('categorias/index.php', ['categorias' => $categorias]);
    }

    private function store(array $requestData): void
    {
        $nome = $requestData['nome'] ?? '';
        if ($nome == '') {
            echo "Nome obrigatório!";
            return;
        }

        $stmt = $this->db->prepare("INSERT INTO categoria (nome) VALUES (?)");
        $stmt->execute([$nome]);

        $_SESSION['mensagem'] = "Categoria cadastrada com sucesso!";
        $this->redirect('/categorias');
    }

    private function edit(array $requestData): void
    {
        $id = $requestData['id'] ?? null;
        if (!$id) die("Categoria não encontrada!");

        $stmt = $this->db->prepare("SELECT * FROM categoria WHERE id=?");
        $stmt->execute([$id]);
        $categoria = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->render('categorias/create.php', ['categoria' => $categoria]);
    }

    private function update(array $requestData): void
    {
        $id = $requestData['id'] ?? null;
        $nome = $requestData['nome'] ?? '';
        if (!$id || $nome == '') {
            echo "Erro!";
            return;
        }

        $stmt = $this->db->prepare("UPDATE categoria SET nome=? WHERE id=?");
        $stmt->execute([$nome, $id]);

        $_SESSION['mensagem'] = "Categoria atualizada com sucesso!";
        $this->redirect('/categorias');
    }

    private function delete(array $requestData): void
    {
        $id = $requestData['id'] ?? null;
        if ($id) {
            $stmt = $this->db->prepare("DELETE FROM categoria WHERE id=?");
            $stmt->execute([$id]);
            $_SESSION['mensagem'] = "Categoria deletada com sucesso!";
        }
        $this->redirect('/categorias');
    }
}
