<?php
$arquivo = 'livros.json';

$novoLivro = [
    'titulo' => $_POST['titulo'] ?? '',
    'autor' => $_POST['autor'] ?? '',
    'ano' => $_POST['ano'] ?? '',
    'genero' => $_POST['genero'] ?? ''
];

if (file_exists($arquivo)) {
    $dados = json_decode(file_get_contents($arquivo), true);
} else {
    $dados = [];
}

$dados[] = $novoLivro;

file_put_contents($arquivo, json_encode($dados, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

header('Location: lista.php?sucesso=1');
exit;
?>