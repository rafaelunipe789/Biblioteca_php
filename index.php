<?php
session_start();

$logado = !empty($_SESSION['logado']) || !empty($_SESSION['usuario']);
if (!$logado) {
    header('Location: login.php');
    exit;
}

if (isset($_GET['action'])) {
    $action = strtolower(trim($_GET['action']));
    if ($action === 'lista') {
        header('Location: lista.php');
        exit;
    }
    if ($action === 'cadrastar' || $action === 'cadastrar') {
    
        header('Location: cadrastar.php');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pilha de Leitura</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body class="page-index">
    <nav class="navbar navbar-expand-lg">
        <div class="container position-relative">
            <div class="nav-actions d-flex gap-2 ms-auto">
                
                <a href="index.php?action=cadrastar" class="btn btn-outline-primary">Cadastrar Livro</a>
                <a href="index.php?action=lista" class="btn btn-primary">Listar Livros</a>
                <?php if ($logado): ?>
                    <a href="logout.php" class="btn btn-outline-danger">Sair</a>
                <?php else: ?>
                    <a href="login.php" class="btn btn-outline-success">Entrar</a>
                <?php endif; ?>
            </div>
            <a class="navbar-brand fw-bold position-absolute start-50 translate-middle-x text-center" href="index.php">🕮 Pilha de Leitura</a>
        </div>
    </nav>

    <div class="container text-center mt-5">
        <h1 class="mb-4">Bem-vindo à sua Pilha de Leitura</h1>
        <p class="lead">Se você gosta de colecionar livros, está no lugar certo. A Pilha de Livros serve para você Colenionador salvar e classificar por autor, genero e ano de publicação.</p>
        <img src="assets/logo.png" alt="Logo" width="200" class="mt-3">
    </div>
</body>
</html>


