<?php
$arquivo = 'livros.json';
$indice = $_GET['id'] ?? null;

if ($indice !== null && file_exists($arquivo)) {
    $livros = json_decode(file_get_contents($arquivo), true);

    if (isset($livros[$indice])) {
        unset($livros[$indice]);
        file_put_contents($arquivo, json_encode(array_values($livros), JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
    }
}

header('Location: lista.php?excluido=1');
exit;
?>