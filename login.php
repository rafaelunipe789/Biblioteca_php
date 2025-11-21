<?php
session_start();

$fallback_users = [
    ['usuario' => 'Rafael', 'senha' => '123456'],
    ['usuario' => 'gabrielsooco', 'senha' => 'b3gabriel'],
];

$erro = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user = trim($_POST['user'] ?? '');
    $pass = $_POST['pass'] ?? '';

    if ($user === '' || $pass === '') {
        $erro = 'Por favor, preencha todos os campos!';
    } else {
        require_once 'db_conexao.php';
        $authenticated = false;

        if (isset($conexao) && $conexao) {
            $tables = ['usuarios', 'users'];
            $candidateUserCols = ['usuario', 'user', 'login', 'username', 'email', 'nome_usuario'];
            $stmt = false;
            $res = null;

            foreach ($tables as $table) {
                foreach ($candidateUserCols as $col) {
                    $sql = sprintf('SELECT id, `%s` AS usuario, senha, nome FROM `%s` WHERE `%s` = ? LIMIT 1', $col, $table, $col);
                    try {
                        $tryStmt = @$conexao->prepare($sql);
                    } catch (\mysqli_sql_exception $e) {
                        $tryStmt = false;
                    }

                    if ($tryStmt) {
                        $tryStmt->bind_param('s', $user);
                        $tryStmt->execute();
                        $res = $tryStmt->get_result();
                        if ($res && $res->num_rows === 1) {
                            $stmt = $tryStmt;
                            break 2;
                        }
                        $tryStmt->close();
                    }
                }
            }

            if ($stmt && $res && $res->num_rows === 1) {
                $row = $res->fetch_assoc();
                $hash = $row['senha'];
                if (function_exists('password_verify') && password_verify($pass, $hash)) {
                    $authenticated = true;
                } elseif (md5($pass) === $hash) {
                    $newHash = password_hash($pass, PASSWORD_DEFAULT);
                    $upd = $conexao->prepare('UPDATE usuarios SET senha = ? WHERE id = ?');
                    if ($upd) {
                        $upd->bind_param('si', $newHash, $row['id']);
                        $upd->execute();
                        $upd->close();
                    }
                    $authenticated = true;
                } elseif ($pass === $hash) {
                    $newHash = password_hash($pass, PASSWORD_DEFAULT);
                    $upd = $conexao->prepare('UPDATE usuarios SET senha = ? WHERE id = ?');
                    if ($upd) {
                        $upd->bind_param('si', $newHash, $row['id']);
                        $upd->execute();
                        $upd->close();
                    }
                    $authenticated = true;
                }

                if ($authenticated) {
                    $_SESSION['usuario'] = $row['usuario'];
                    $_SESSION['nome'] = $row['nome'] ?? $row['usuario'];
                    $_SESSION['user_id'] = $row['id'];
                    $_SESSION['logado'] = true;
                    header('Location: index.php');
                    exit;
                }

                $stmt->close();
            }
        }

        if (!$authenticated) {
            foreach ($fallback_users as $fu) {
                if ($user === $fu['usuario'] && $pass === $fu['senha']) {
                    $_SESSION['usuario'] = $user;
                    $_SESSION['nome'] = $user;
                    $_SESSION['logado'] = true;
                    header('Location: index.php');
                    exit;
                }
            }
        }

        $erro = $erro ?: 'Usuário e/ou senha inválido(s).';
    }
}
?>
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8" />
    <title>Login - Pilha de Leitura</title>
    <link rel="stylesheet" href="css/login.css">
    <meta name="viewport" content="width=device-width,initial-scale=1">
</head>
<body>
    <div class="global">
        <h1 class="text-center">🕮 Pilha de Leitura</h1>

        <?php if ($erro): ?>
            <div class="small center" style="color:#b00020; margin-bottom:1rem;"><?= htmlspecialchars($erro) ?></div>
        <?php endif; ?>

        <form method="post" action="">
            <label>Usuário: <input type="text" name="user" value="<?= htmlspecialchars($_POST['user'] ?? '') ?>" /></label><br /><br />
            <label>Senha: <input type="password" name="pass" /></label><br /><br />
            <input type="submit" name="submit" value="Logar!" />
        </form>
    </div>
</body>
</html>

