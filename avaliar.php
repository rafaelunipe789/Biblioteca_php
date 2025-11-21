<?php
$arquivo = 'livros.json';
$livros = [];

if (file_exists($arquivo)) {
    $livros = json_decode(file_get_contents($arquivo), true);
}

$id = isset($_GET['id']) ? (int) $_GET['id'] : null;
if ($id === null || !isset($livros[$id])) {
   
    header('Location: lista.php');
    exit;
}

$livro = $livros[$id];
$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $nota = $_POST['nota'] ?? '';
 
    $nota = str_replace(',', '.', $nota);
    if ($nota === '' || !is_numeric($nota)) {
        $erro = 'Informe uma nota válida entre 1 e 10.';
    } else {
        $notaFloat = (float) $nota;
        if ($notaFloat < 1 || $notaFloat > 10) {
            $erro = 'A nota deve ser entre 1.0 e 10.0.';
        } else {
            $notaFloat = round($notaFloat, 1);

            $livros[$id]['avaliacao'] = $notaFloat;
            file_put_contents($arquivo, json_encode($livros, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

            header('Location: lista.php?avaliado=1');
            exit;
        }
    }
}

?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width,initial-scale=1">
    <title>Avaliar: <?= htmlspecialchars($livro['titulo']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
    <style>
        .card { max-width:720px; margin:3rem auto; }
        .nota-input { width:140px; }
    </style>
</head>
<body class="page-lista">
    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a href="index.php" class="navbar-brand">📚 Pilha de Livros!</a>
        </div>
    </nav>

    <div class="container">
        <div class="card p-4 mt-4">
            <h4>Avaliar livro</h4>
            <p class="mb-1"><strong>Título:</strong> <?= htmlspecialchars($livro['titulo']) ?></p>
            <p class="mb-1"><strong>Autor:</strong> <?= htmlspecialchars($livro['autor']) ?></p>
            <p class="mb-3"><strong>Avaliação atual:</strong> <?= isset($livro['avaliacao']) ? htmlspecialchars($livro['avaliacao']) : 'Sem avaliação' ?></p>

            <?php if ($erro): ?>
                <div class="alert alert-danger"><?= htmlspecialchars($erro) ?></div>
            <?php endif; ?>

            <form method="POST" class="row g-2 align-items-center">
                <div class="col-auto">
                    <label for="nota" class="col-form-label">Nota (1.0 - 10.0):</label>
                </div>
                <div class="col-auto">
                    <input type="number" step="0.1" min="1" max="10" name="nota" id="nota" class="form-control nota-input" value="<?= isset($livro['avaliacao']) ? htmlspecialchars($livro['avaliacao']) : '' ?>" required>
                </div>
                <div class="col-auto">
                    <button class="btn btn-primary" type="submit">Salvar avaliação</button>
                </div>
                <div class="col-12 mt-3">
                    <a href="lista.php" class="btn btn-secondary">Voltar à lista</a>
                </div>
            </form>
        </div>
    </div>
</body>
</html>