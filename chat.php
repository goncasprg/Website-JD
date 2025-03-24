// chat.php

// Defina sua chave da API do GPT-3 (substitua pelo seu valor)
$apiKey = 'YOUR_API_KEY_HERE';

// Função para enviar a mensagem do usuário e obter a resposta da IA
function getAIResponse($userMessage) {
    global $apiKey;
    
    // URL da API do GPT-3
    $url = 'https://api.openai.com/v1/completions';
    
    // Cabeçalhos necessários
    $headers = [
        'Content-Type: application/json',
        'Authorization: Bearer ' . $apiKey,
    ];

    // Corpo da requisição para a API
    $data = [
        'model' => 'text-davinci-003', // Você pode usar outros modelos se necessário
        'prompt' => $userMessage,
        'max_tokens' => 150,
        'temperature' => 0.7,
    ];

    // Iniciar uma requisição CURL para a API
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));

    // Executar a requisição e obter a resposta
    $response = curl_exec($ch);

    // Verificar erros da requisição
    if(curl_errno($ch)) {
        return "Erro na comunicação com a IA.";
    }

    // Fechar a conexão CURL
    curl_close($ch);

    // Decodificar a resposta JSON da API
    $responseData = json_decode($response, true);
    
    // Retornar a resposta da IA
    return $responseData['choices'][0]['text'];
}

// Verificar se o formulário foi enviado
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userMessage = $_POST['user_message'];
    
    // Obter resposta da IA
    $aiResponse = getAIResponse($userMessage);
    
    // Salvar a interação no banco de dados (opcional)
    // Aqui você pode continuar com o código para registrar no banco de dados, como mostrado antes.
    
    // Retornar a resposta para o front-end (JSON)
    echo json_encode(['ai_response' => $aiResponse]);
}
