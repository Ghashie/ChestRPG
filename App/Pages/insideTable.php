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
                <option value="4">D4</option>
                <option value="6">D6</option>
                <option value="8">D8</option>
                <option value="10">D10</option>
                <option value="12">D12</option>
                <option value="20">D20</option>
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
        console.log('Mensagem recebida:', event.data);

        // Obtenha o contêiner de mensagens
        const messageContainer = document.getElementById('message-container');

        // Crie um novo elemento de parágrafo para a mensagem
        const newMessage = document.createElement('p');

        // Adicione a mensagem ao novo elemento
        newMessage.textContent = event.data;

        // Adicione o novo elemento ao contêiner de mensagens
        messageContainer.appendChild(newMessage);

        // Role até o final do contêiner para exibir a última mensagem
        messageContainer.scrollTop = messageContainer.scrollHeight;
    };

    function sendMessage() {
        const messageInput = document.getElementById('message-input');
        const message = messageInput.value;

        if (conn.readyState === WebSocket.OPEN) {
            // Inclua o nome do usuário na mensagem
            const user = '<?php echo addslashes($member['usernameUser']); ?>';
            const formattedMessage = `${user}: ${message}`;

            // Envia a mensagem para todos, incluindo o remetente
            conn.send(formattedMessage);
            messageInput.value = '';
            console.log('Mensagem enviada:', formattedMessage);
        }
    }

    // Função para rolar dados
    function rollDice() {
        const user = '<?php echo addslashes($member['usernameUser']); ?>';
        const diceType = parseInt(document.getElementById('dice-type').value, 10);
        const quantity = parseInt(document.getElementById('dice-quantity').value, 10);

        // Verifique se os valores são números válidos
        if (isNaN(diceType) || diceType <= 0 || isNaN(quantity) || quantity <= 0) {
            console.error('Valores inválidos para o tipo de dado ou quantidade.');
            return;
        }

        // Simula o lançamento de dados e gera resultados
        const results = [];
        for (let i = 0; i < quantity; i++) {
            const result = Math.floor(Math.random() * diceType) + 1;
            results.push(result);
        }

        // Construa as mensagens com os resultados dos dados
        const diceMessages = results.map(result => `${user} rodou um D${diceType} = ${result}`);

        // Envia as mensagens dos resultados dos dados para o WebSocket
        diceMessages.forEach(message => {
            conn.send(message);
            displayMessage(message); // Exibir a mensagem localmente
        });
    }

    // Função para exibir mensagens localmente
    function displayMessage(message) {
        const messageContainer = document.getElementById('message-container');
        const newMessage = document.createElement('p');
        newMessage.textContent = message;
        messageContainer.appendChild(newMessage);
        messageContainer.scrollTop = messageContainer.scrollHeight;
    }
</script>

</html>