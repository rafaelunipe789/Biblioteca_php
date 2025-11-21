<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastrar Livro</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="page-lista">

    <nav class="navbar navbar-dark bg-dark">
        <div class="container">
            <a href="index.php" class="navbar-brand">🕮 Plha de Leitura</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="mb-4 text-center">Cadastrar Novo Livro</h2>

        <form action="salvar.php" method="POST" class="shadow p-4 rounded bg-white">
            <div class="mb-3">
                <label class="form-label">Título:</label>
                <input type="text" name="titulo" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Autor:</label>
                <input type="text" name="autor" class="form-control" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Ano:</label>
                <input type="number" name="ano" class="form-control" min="1000" max="9999" required>
            </div>
            <div class="mb-3">
                <label class="form-label">Gênero:</label>
                <input type="text" name="genero" class="form-control" required>
            </div>

            <div class="text-center">
                <button type="submit" class="btn btn-success">Salvar Livro</button>
                <a href="index.php" class="btn btn-secondary">Voltar</a>
            </div>
        </form>
    </div>

</body>
</html>