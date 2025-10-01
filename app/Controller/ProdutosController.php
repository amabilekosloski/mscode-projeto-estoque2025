<?php

namespace App\Controller;

use App\Database\Database;
use PDO;

class ProdutosController extends AbstractController
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
            $categorias = $this->db->query("SELECT * FROM categoria ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);
            $this->render('produtos/create.php', ['categorias' => $categorias]);
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

        $produtos = $this->db->query("
            SELECT p.*, c.nome AS categoria_nome
            FROM produtos p
            LEFT JOIN categoria c ON c.id = p.categoria_id
            ORDER BY p.id
        ")->fetchAll(PDO::FETCH_ASSOC);

        $this->render('produtos/index.php', ['produtos' => $produtos]);
    }

    private function store(array $requestData): void
    {
        $nome = $requestData['nome'] ?? '';
        $descricao = $requestData['descricao'] ?? '';
        $categoria_id = $requestData['categoria_id'] ?? null;
        $quantidade = $requestData['quantidade'] ?? 0;
        $valor = $requestData['valor'] ?? 0;

        if ($nome == '' || $valor == 0) {
            echo "Preencha nome e valor!";
            return;
        }

        $stmt = $this->db->prepare("INSERT INTO produtos (nome, descricao, categoria_id, quantidade_disponivel, valor) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$nome, $descricao, $categoria_id, $quantidade, $valor]);

        $this->redirect('/produtos');
    }

    private function edit(array $requestData): void
    {
        $id = $requestData['id'] ?? null;
        if (!$id) die("Produto não encontrado!");

        $produto = $this->db->prepare("SELECT * FROM produtos WHERE id=?");
        $produto->execute([$id]);
        $produto = $produto->fetch(PDO::FETCH_ASSOC);

        $categorias = $this->db->query("SELECT * FROM categoria ORDER BY nome")->fetchAll(PDO::FETCH_ASSOC);

        $this->render('produtos/create.php', ['produto' => $produto, 'categorias' => $categorias]);
    }

    private function update(array $requestData): void
    {
        $id = $requestData['id'] ?? null;
        $nome = $requestData['nome'] ?? '';
        $descricao = $requestData['descricao'] ?? '';
        $categoria_id = $requestData['categoria_id'] ?? null;
        $quantidade = $requestData['quantidade'] ?? 0;
        $valor = $requestData['valor'] ?? 0;

        if (!$id || $nome == '' || $valor == 0) {
            echo "Erro ao atualizar!";
            return;
        }

        $stmt = $this->db->prepare("UPDATE produtos SET nome=?, descricao=?, categoria_id=?, quantidade_disponivel=?, valor=? WHERE id=?");
        $stmt->execute([$nome, $descricao, $categoria_id, $quantidade, $valor, $id]);

        $this->redirect('/produtos');
    }

    private function consumir(array $requestData): void
{
    $id = $requestData['id'] ?? null;
    $quantidade = $requestData['quantidade'] ?? 0;

    if (!$id || $quantidade <= 0) {
        $_SESSION['mensagem'] = "Erro ao consumir produto!";
        $this->redirect('/produtos');
        return;
    }

    $stmt = $this->db->prepare("SELECT quantidade_disponivel FROM produtos WHERE id=?");
    $stmt->execute([$id]);
    $produto = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$produto || $produto['quantidade_disponivel'] < $quantidade) {
        $_SESSION['mensagem'] = "Quantidade insuficiente em estoque!";
        $this->redirect('/produtos');
        return;
    }

    $novaQuantidade = $produto['quantidade_disponivel'] - $quantidade;
    $stmt = $this->db->prepare("UPDATE produtos SET quantidade_disponivel=? WHERE id=?");
    $stmt->execute([$novaQuantidade, $id]);

    $_SESSION['mensagem'] = "Produto consumido com sucesso!";
    $this->redirect('/produtos');
}


    private function delete(array $requestData): void
    {
        $id = $requestData['id'] ?? null;
        if ($id) {
            $stmt = $this->db->prepare("DELETE FROM produtos WHERE id=?");
            $stmt->execute([$id]);
        }
        $this->redirect('/produtos');
    }
}
