// db.php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "site_interactions";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Salvar a mensagem e resposta da IA
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_message = $_POST['user_message'];
    $ai_response = "Eu sou uma IA, como posso te ajudar?";  // Simulando IA
    
    $stmt = $conn->prepare("INSERT INTO messages (user_message, ai_response) VALUES (?, ?)");
    $stmt->bind_param("ss", $user_message, $ai_response);
    $stmt->execute();
    $stmt->close();
}
