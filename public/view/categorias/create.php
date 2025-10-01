<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$isEdit = isset($categoria);
$title = $isEdit ? "Editar Categoria" : "Adicionar Categoria";
?>
<!doctype html>
<html lang="pt-BR">
<head>
  <meta charset="UTF-8">
  <title><?= $title ?> - Estoque</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-4">
    <div class="card shadow">
        <div class="card-header bg-success text-white">
            <h4 class="mb-0"><?= $title ?></h4>
        </div>
        <div class="card-body">
            <form method="POST" action="/categorias">
                <?php if($isEdit): ?>
                    <input type="hidden" name="id" value="<?= $categoria['id'] ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Nome da Categoria</label>
                    <input type="text" name="nome" class="form-control" required
                           value="<?= $isEdit ? htmlspecialchars($categoria['nome']) : '' ?>">
                </div>

                <button type="submit" class="btn btn-success"><?= $isEdit ? "Atualizar" : "Cadastrar" ?></button>
                <a href="/categorias" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
