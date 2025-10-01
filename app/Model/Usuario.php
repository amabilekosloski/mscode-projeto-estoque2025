<?php

namespace App\Model;

use App\Database\Query;

class Usuario
{
    private Query $db;

    public function __construct()
    {
        $this->db = new Query();
    }

    public function buscarPorEmail(string $email): ?array
    {
        $resultado = $this->db->select('logins', "email='{$email}'");
        return $resultado[0] ?? null;
    }

    public function criar(string $email, string $senha): bool
    {
        $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

        $id = $this->db->insert('logins', [
            'email' => $email,
            'senha' => $senhaHash
        ]);

        return $id !== false;
    }

    public function atualizarSenha(int $id, string $novaSenha): bool
    {
        $senhaHash = password_hash($novaSenha, PASSWORD_DEFAULT);
        return $this->db->update('logins', ['senha' => $senhaHash], "id={$id}");
    }

    public function deletar(int $id): bool
    {
        return $this->db->delete('logins', "id={$id}");
    }
}
