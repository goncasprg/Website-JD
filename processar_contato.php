<?php
// Conexão com o banco de dados
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "contatos"; // Nome do banco de dados corrigido para 'contatos'

$conn = new mysqli($servername, $username, $password, $dbname);

// Verifica se houve erro na conexão
if ($conn->connect_error) {
    // Retorna um erro em formato XML
    $response = new SimpleXMLElement('<response/>');
    $response->addChild('status', 'erro');
    $response->addChild('message', 'Conexão falhou: ' . $conn->connect_error);
    header('Content-Type: application/xml');
    echo $response->asXML();
    exit;
}

// Verifica se os dados foram enviados via POST
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Obtém os dados do formulário
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $mensagem = $_POST['mensagem'];

    // Validação básica: Verifica se os campos estão vazios
    if (empty($nome) || empty($email) || empty($mensagem)) {
        // Retorna um erro em formato XML se algum campo estiver vazio
        $response = new SimpleXMLElement('<response/>');
        $response->addChild('status', 'erro');
        $response->addChild('message', 'Por favor, preencha todos os campos.');
        header('Content-Type: application/xml');
        echo $response->asXML();
    } else {
        // Prepara a consulta para evitar SQL injection
        $stmt = $conn->prepare("INSERT INTO contatos (nome, email, mensagem) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $nome, $email, $mensagem);

        // Executa a consulta e verifica se foi bem-sucedida
        if ($stmt->execute()) {
            // Retorna sucesso em formato XML
            $response = new SimpleXMLElement('<response/>');
            $response->addChild('status', 'sucesso');
            $response->addChild('message', 'Mensagem enviada com sucesso!');
            header('Content-Type: application/xml');
            echo $response->asXML();
        } else {
            // Retorna erro em formato XML caso falhe a inserção
            $response = new SimpleXMLElement('<response/>');
            $response->addChild('status', 'erro');
            $response->addChild('message', 'Erro ao enviar a mensagem: ' . $stmt->error);
            header('Content-Type: application/xml');
            echo $response->asXML();
        }

        // Fecha a consulta
        $stmt->close();
    }

    // Fecha a conexão
    $conn->close();
}
?>
