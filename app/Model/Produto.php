<?php

namespace App\Model;

use App\Database\Query;

class Produto
{
    private Query $db;

    public function __construct()
    {
        $this->db = new Query();
    }

    public function listar(): array
    {
        return $this->db->select('produtos p LEFT JOIN categoria c ON p.categoria_id=c.id', null, 'p.*, c.nome AS categoria_nome') ?: [];
    }

    public function buscarPorId(int $id): ?array
    {
        $resultado = $this->db->select('produtos', "id={$id}");
        return $resultado[0] ?? null;
    }

    public function criar(array $dados): int|false
    {
        return $this->db->insert('produtos', $dados);
    }

    public function atualizar(int $id, array $dados): bool
    {
        return $this->db->update('produtos', $dados, "id={$id}");
    }

    public function deletar(int $id): bool
    {
        return $this->db->delete('produtos', "id={$id}");
    }
}
