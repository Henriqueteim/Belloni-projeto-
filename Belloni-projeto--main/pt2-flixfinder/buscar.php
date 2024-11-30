<?php
// Verificar se o formulário foi enviado via POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $genero = $_POST['genero'] ?? '';
    $faixa_etaria = $_POST['faixa-etaria'] ?? '';
    $ano = $_POST['ano'] ?? '';

    // Definir a URL da API de IA (substitua com a URL da API real)
    $apiUrl = "https://api.exemplo.com/recomendacoes";

    // Dados que serão enviados para a API
    $data = [
        'genero' => $genero,
        'faixa_etaria' => $faixa_etaria,
        'ano' => $ano
    ];

    // Inicializar o cURL
    $ch = curl_init();

    // Configurar cURL para enviar uma solicitação POST
    curl_setopt($ch, CURLOPT_URL, $apiUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Bearer SUA_CHAVE_DE_API_AQUI' // Se necessário
    ]);

    // Executar a solicitação e obter a resposta
    $response = curl_exec($ch);

    // Verificar se ocorreu algum erro na requisição
    if(curl_errno($ch)) {
        echo 'Erro na requisição cURL: ' . curl_error($ch);
        exit;
    }

    // Fechar a conexão cURL
    curl_close($ch);

    // Decodificar a resposta JSON da API
    $filmes = json_decode($response, true);

    // Verificar se a resposta contém dados
    if (!$filmes) {
        echo "Nenhum filme encontrado ou erro na API.";
        exit;
    }
} else {
    $filmes = [];
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resultados - Flix Finder</title>
    <link rel="stylesheet" href="../pt2-flixfinder/scr/style-principal.css">
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
                        <img src="<?= htmlspecialchars($filme['poster']); ?>" alt="<?= htmlspecialchars($filme['titulo']); ?>">
                        <div class="movie-title"><?= htmlspecialchars($filme['titulo']); ?></div>
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
