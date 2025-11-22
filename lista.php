<?php
$arquivo = 'livros.json';
$livros = [];

if (file_exists($arquivo)) {
    $livros = json_decode(file_get_contents($arquivo), true);
}
$busca = $_GET['busca'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Listar Livros</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="page-lista">

<nav class="navbar navbar-dark bg-dark">
    <div class="container">
        <a href="index.php" class="navbar-brand">🕮 Pilha de Livros!</a>
    </div>
</nav>

<div class="container mt-4">
    <?php if (isset($_GET['excluido']) && $_GET['excluido'] == '1'): ?>
        <div class="alert alert-success text-center">Livro excluído com sucesso.</div>
    <?php endif; ?>
    <h2 class="mb-3 text-center">Livros Cadastrados</h2>

    <form class="mb-4 text-center" method="GET" action="">
        <input type="text" name="busca" value="<?= htmlspecialchars($busca) ?>" placeholder="Buscar por título ou autor" class="form-control w-50 d-inline">
        <button class="btn btn-primary">Buscar</button>
    </form>

    <?php if (empty($livros)): ?>
        <div class="alert alert-warning text-center">Nenhum livro cadastrado.</div>
    <?php else: ?>
        <table class="table table-striped table-hover align-middle">
            <thead class="table-dark">
                <tr>
                    <th>Título</th>
                    <th>Autor</th>
                    <th>Ano</th>
                    <th>Gênero</th>
                    <th class="text-center">Avaliação</th>
                    <th class="text-center">Ações</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($livros as $i => $livro): ?>
                    <?php
                        $titulo = strtolower($livro['titulo']);
                        $autor  = strtolower($livro['autor']);
                        $buscaLower = strtolower($busca);

                        if ($busca && !str_contains($titulo, $buscaLower) && !str_contains($autor, $buscaLower)) {
                            continue;
                        }
                    ?>
                    <tr>
                        <td><?= htmlspecialchars($livro['titulo']) ?></td>
                        <td><?= htmlspecialchars($livro['autor']) ?></td>
                        <td><?= htmlspecialchars($livro['ano']) ?></td>
                        <td><?= htmlspecialchars($livro['genero']) ?></td>
                        <td class="text-center">
                            <?php if (isset($livro['avaliacao'])): ?>
                                <span class="badge bg-primary"><?= number_format((float)$livro['avaliacao'], 1) ?></span>
                            <?php else: ?>
                                <span class="text-muted">—</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <a href="avaliar.php?id=<?= $i ?>" class="btn btn-info btn-sm me-2">Avaliar</a>
                            <a href="excluir.php?id=<?= $i ?>" 
                               class="btn btn-danger btn-sm"
                               onclick="return confirm('Tem certeza que deseja excluir este livro?')">
                               Excluir
                            </a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

    <div class="text-center mt-4">
        <a href="cadrastar.php" class="btn btn-success">Cadastrar Novo Livro</a>
        <a href="index.php" class="btn btn-secondary">Voltar ao Início</a>
    </div>
</div>

</body>
</html>