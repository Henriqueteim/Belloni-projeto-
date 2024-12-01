<?php
// URL da API
$apiUrl = "https://generativelanguage.googleapis.com/v1beta/models/gemini-1.5-flash-latest:generateContent?key=AIzaSyA0SrSINptAnc4cr7KFpCXYyXdqNS8_uns"; 

// Verificar se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST')
    $genero = $_POST['genero'] ?? '';
    $faixa_etaria = $_POST['faixa-etaria'] ?? '';
    $ano = $_POST['ano'] ?? '';

// Inicializar o cURL
$ch = curl_init($apiUrl);

// Configurar cURL para enviar uma solicitação POST
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Authorization: Bearer AIzaSyA0SrSINptAnc4cr7KFpCXYyXdqNS8_uns' 
]);
// Dados que serão enviados para a API
$data = <<<DATA
{
'genero' => $genero,
'faixa_etaria' => $faixa_etaria,
'ano' => $ano

DATA;

curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

// Executar a solicitação e obter a resposta
$response = curl_exec($ch);

// Verificar erros na requisição
if (curl_errno($ch)) {
    echo '<p>Erro na requisição cURL: ' . htmlspecialchars(curl_error($ch)) . '</p>';
    curl_close($ch);
    exit;
}

// Fechar cURL
curl_close($ch);

// Decodificar a resposta
$filmes = json_decode($response, true);

// Exibir os filmes
if (is_array($filmes) && !empty($filmes)) {
foreach ($filmes as $filme) {
    echo "Título: " . htmlspecialchars($filme['titulo']) . "<br>";
}
} else {
echo "Nenhum filme encontrado.";
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados - Flix Finder</title>
    <link rel="stylesheet" href="scr/style-principal.css">
</head>
<body>
    <div class="container">
        <h1>Resultados da Busca</h1>

        <?php if (empty($filmes)): ?>
            <p>Nenhum filme encontrado com os critérios informados.</p>
        <?php else: ?>
            <div class="movie-container" id="movieContainer">
                <?php foreach ($filmes as $filme): ?>
                    <div class="movie">
                        <img 
                            src="<?= htmlspecialchars($filme['poster'] ?? ''); ?>" 
                            alt="<?= htmlspecialchars($filme['titulo'] ?? 'Sem título'); ?>">
                        <div class="movie-title"><?= htmlspecialchars($filme['titulo'] ?? 'Sem título'); ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <div class="footer">
            <p>© 2024 FLIX FINDER - Todos os direitos reservados.</p>
        </div>
    </div>
</body>
</html>
