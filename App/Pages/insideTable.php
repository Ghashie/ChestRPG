<?php
require_once '../Model/conn.php';
require_once '../Model/tables.php';
require_once '../Model/tablesDao.php';
require_once '../Model/user.php';
require_once '../Model/userDao.php';
require_once '../Model/members.php';
require_once '../Model/membersDao.php';

if (!isset($_SESSION)) {
    session_start();
}

// Verifique se o usuário está logado
if (!isset($_SESSION['idUser'])) {
    header("Location: ../Login/loginUser.php");
    exit();
}

// Verifique se o ID da mesa está presente na URL
if (!isset($_GET['idTable'])) {
    // O ID da mesa não está presente na URL, redirecionar para uma página de erro ou exibir uma mensagem.
    echo "ID da mesa não fornecido.";
    exit();
}

// Obtenha o ID da mesa da URL
$idTable = $_GET['idTable'];

$tableDao = new \App\Model\TablesDao();
$table = $tableDao->getTableById($idTable);

// Verifique se a mesa foi encontrada
if (!$table) {
    // A mesa com o ID fornecido não foi encontrada, você pode redirecionar para uma página de erro ou exibir uma mensagem.
    echo "Mesa não encontrada.";
    header("Location: usersTable.php");
    exit();
}

$membersDao = new \App\Model\MembersDao();
$membersList = $membersDao->getMembersByTableId($idTable);

// Verifique se $membersList é uma array antes de usar no loop foreach
if (!is_array($membersList)) {
    $membersList = [];
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mesa:
        <?= $table['nameTable'] ?>
    </title>
    <link rel="stylesheet" href="../../css/insideTable.css"> <!-- Ajuste o caminho conforme necessário -->
    <script src="../../js/insideTable.js"></script> <!-- Ajuste o caminho conforme necessário -->
</head>

<body>
    <header>
        <h1>Mesa:
            <?= $table['nameTable'] ?>
        </h1>
        <h2>Membros:</h2>
        <ul id="members-list">
            <?php foreach ($membersList as $member): ?>
                <li>
                    <?= $member['usernameUser'] ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </header>

    <main>
        <section id="chat">
            <div id="message-container">
                <!-- Aqui serão exibidas as mensagens do chat -->
            </div>
            <form id="message-form">
                <input type="text" id="message-input" placeholder="Digite sua mensagem...">
                <button type="button" id="send-button" onclick="sendMessage()">Enviar</button>
            </form>
        </section>

        <section id="dice-roller">
            <h2>Rolar Dados</h2>
            <label for="dice-type">Tipo de Dado:</label>
            <select id="dice-type">
                <option value="d4">D4</option>
                <option value="d6">D6</option>
                <option value="d8">D8</option>
                <option value="d10">D10</option>
                <option value="d12">D12</option>
                <option value="d20">D20</option>
            </select>
            <label for="dice-quantity">Quantidade:</label>
            <input type="number" id="dice-quantity" min="1" value="1">
            <button type="button" id="roll-button" onclick="rollDice()">Rolar</button>
            <p id="result-container"></p>
        </section>
    </main>
</body>
<script>
    const conn = new WebSocket('ws://localhost:8080');
    conn.onopen = function (event) {
        console.log('Conexão WebSocket aberta');
    };

    conn.onmessage = function (event) {
        console.log(`Mensagem recebida: ${event.data}`);
        // Manipule a mensagem recebida (chat ou resultado do dado) e atualize a interface do usuário
        const messageContainer = document.getElementById('message-container');
        messageContainer.innerHTML += `<p>${event.data}</p>`;
    };

    function sendMessage() {
    const messageInput = document.getElementById('message-input');
    const message = messageInput.value;

    if (conn.readyState === WebSocket.OPEN) {
        conn.send(message);
        messageInput.value = '';
        console.log('Mensagem enviada:', message);
    } 
}

    // Função para rolar dados
    function rollDice() {
        const diceType = document.getElementById('dice-type').value;
        const quantity = document.getElementById('dice-quantity').value;
        const result = Math.floor(Math.random() * diceType * quantity) + 1;
        const resultContainer = document.getElementById('result-container');
        resultContainer.innerHTML = `<p>${quantity}d${diceType}: ${result}</p>`;

        // Envia a mensagem do resultado do dado para o WebSocket
        conn.send(`${quantity}d${diceType}: ${result}`);
    }
</script>
</html>

