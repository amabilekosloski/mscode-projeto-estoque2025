<?php

namespace App\Model;

use App\Database\Query;

class Categoria
{
    private Query $db;

    public function __construct()
    {
        $this->db = new Query();
    }

    public function listar(): array
    {
        return $this->db->select('categoria') ?: [];
    }

    public function buscarPorId(int $id): ?array
    {
        $resultado = $this->db->select('categoria', "id={$id}");
        return $resultado[0] ?? null;
    }

    public function criar(string $nome): int|false
    {
        return $this->db->insert('categoria', ['nome' => $nome]);
    }

    public function atualizar(int $id, string $nome): bool
    {
        return $this->db->update('categoria', ['nome' => $nome], "id={$id}");
    }

    public function deletar(int $id): bool
    {
        return $this->db->delete('categoria', "id={$id}");
    }
}
