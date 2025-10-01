<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$isEdit = isset($produto);
$title = $isEdit ? "Editar Produto" : "Adicionar Produto";
$actionUrl = $isEdit ? "/produtos/update" : "/produtos/store";
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
        <div class="card-header bg-primary text-white">
            <h4 class="mb-0"><?= $title ?></h4>
        </div>
        <div class="card-body">
            <form method="POST" action="/produtos">
                <?php if($isEdit): ?>
                    <input type="hidden" name="id" value="<?= $produto['id'] ?>">
                <?php endif; ?>

                <div class="mb-3">
                    <label class="form-label">Nome</label>
                    <input type="text" name="nome" class="form-control" required value="<?= $isEdit ? htmlspecialchars($produto['nome']) : '' ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Descrição</label>
                    <textarea name="descricao" class="form-control"><?= $isEdit ? htmlspecialchars($produto['descricao']) : '' ?></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Categoria</label>
                    <select name="categoria_id" class="form-select" required>
                        <option value="">Selecione...</option>
                        <?php foreach($categorias as $c): ?>
                            <option value="<?= $c['id'] ?>" <?= $isEdit && $produto['categoria_id']==$c['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($c['nome']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="mb-3">
                    <label class="form-label">Quantidade</label>
                    <input type="number" name="quantidade" class="form-control" min="0" required value="<?= $isEdit ? $produto['quantidade_disponivel'] : 0 ?>">
                </div>

                <div class="mb-3">
                    <label class="form-label">Preço</label>
                    <input type="number" step="0.01" name="valor" class="form-control" min="0" required value="<?= $isEdit ? $produto['valor'] : 0 ?>">
                </div>

                <button type="submit" class="btn btn-primary"><?= $isEdit ? "Atualizar" : "Cadastrar" ?></button>
                <a href="/produtos" class="btn btn-secondary">Cancelar</a>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
