<?php
require_once '../Model/conn.php';
require_once '../Model/tables.php';
require_once '../Model/tablesDao.php';
require_once '../Model/user.php';
require_once '../Model/userDao.php';
require_once '../Model/members.php';
require_once '../Model/membersDao.php';
require_once '../Model/charactercard.php';
require_once '../Model/charactercardDao.php';

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

$user = $_SESSION['usernameUser'];
$_SESSION['current_user'] = isset($user['usernameUser']) ? $user['usernameUser'] : '';


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

//Parte das fichas
$characterCardDao = new \App\Model\CharacterCardDao();

// Adicione a lógica para deletar a ficha
if ($_SERVER["REQUEST_METHOD"] == "GET" && isset($_GET["delete"])) {
  $idCharacter = $_GET["delete"];
  $deleted = $characterCardDao->deleteCharacterCard($idCharacter);

  if ($deleted) {
    echo "Ficha deletada com sucesso!";
  } else {
    echo "Erro ao deletar a ficha.";
  }
}

// Adicione a lógica para salvar o arquivo PDF no banco de dados
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["enviar"])) {
  $uploadedFile = $_FILES['pdf-file'];

  $uploadDir = 'pdf/';
  $uploadedFilePath = $uploadDir . basename($uploadedFile['name']);
  move_uploaded_file($uploadedFile['tmp_name'], $uploadedFilePath);

  $characterCard = new \App\Model\CharacterCard();
  $characterCard->setIdUserFk($_SESSION['idUser']);
  $characterCard->setIdTableFk($idTable);
  $characterCard->setCharacterPDF($uploadedFile['name']);

  $characterCardDao->insertCharacterCard($characterCard);
}

// Obtém novamente as fichas após o envio
$characterCards = $characterCardDao->getCharacterCardsByUserAndTable($_SESSION['idUser'], $idTable);

?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ChestRPG -
    <?= $table['nameTable'] ?>
  </title>
  <link rel="stylesheet" href="../../css/insideTable.css"> <!-- Ajuste o caminho conforme necessário -->
  <script src="../../js/insideTable.js"></script> <!-- Ajuste o caminho conforme necessário -->
  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  <script src="js/insideTable.js"></script>
</head>

<body>
  <!--
    <header>
        <button id="exit-button" onclick="exitChat()">Sair do Chat</button>
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
    -->
  <div class="app">
    <header class="header">
      <div class="header-menu">
        <a class="menu-link" onclick="mostrarConteudo('conteudo1')" href="#">Chat</a>
        <a class="menu-link " onclick="mostrarConteudo('conteudo2')" href="#">Fichas</a>
      </div>
      <div class="header-profile">
        <div class="notification">
          <span class="notification-number">0</span>
          <svg viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round"
            stroke-linejoin="round" class="feather feather-bell">
            <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0" />
          </svg>
        </div>
        <box-icon name='log-in' color='#ffffff' onclick="exitChat()" id="exit-button"></box-icon>
      </div>
    </header>

    <div class="wrapper">
      <div class="left-side">
        <div class="side-titles-container">
          <div class="side-title">
            Membros
          </div>
          <ul id="members-list">
            <?php foreach ($membersList as $member): ?>
              <li>
                <?= $member['usernameUser'] ?>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>
      </div>

      <div class="main-container">
        <main class="chat conteudo" id="conteudo1">
          <div class="chat-title">
            <h1>Mesa:
              <?= $table['nameTable'] ?>
            </h1>
            <h2>ChestRPG</h2>
          </div>

          <div id="message-container">
            <!-- Aqui serão exibidas as mensagens do chat -->
          </div>
          <form>
            <div class="message-box">
              <input type="text" id="message-input" class="message-input" placeholder="Digite sua mensagem...">
              <section id="dice-roller">
                <select id="dice-type">
                  <option value="4">D4</option>
                  <option value="6">D6</option>
                  <option value="8">D8</option>
                  <option value="10">D10</option>
                  <option value="12">D12</option>
                  <option value="20">D20</option>
                </select>
                <input type="number" id="dice-quantity" min="1" value="1" class="number-input" placeholder="Qtd">
                <box-icon name='dice-6' type='solid' color='#ffffff' id="roll-button" onclick="rollDice()"></box-icon>
                <p id="result-container"></p>
              </section>
              <button type="button" id="send-button" class="message-submit" onclick="sendMessage()">Enviar</button>

            </div>
          </form>
        </main>
      </div>

      <div class="bg"></div>

      <div class="conteudo" id="conteudo2">
        <h2>Envio de Fichas</h2>
        <form action="" method="post" enctype="multipart/form-data">
          <label for="pdf-file">Selecione um PDF:</label>
          <input type="file" name="pdf-file" id="pdf-file" accept=".pdf" required>
          <button type="submit" name="enviar">Enviar PDF</button>
        </form>

        <h2>Fichas Enviadas</h2>

        <!-- Lista de PDFs enviados -->
        <ul>
          <?php foreach ($characterCards as $characterCard): ?>
            <li>
              <a href="download.php?idTable=<?= $idTable ?>&filename=<?= urlencode($characterCard->getCharacterPDF()); ?>"
                download>
                Download
              </a>
              <a href="?idTable=<?= $idTable ?>&delete=<?= $characterCard->getIdCharacter(); ?>"
                onclick="return confirm('Tem certeza que deseja deletar?')">Deletar</a>
            </li>
          <?php endforeach; ?>
        </ul>
      </div>

      <div class="bg"></div>

    </div>
  </div>
  <div class="overlay-app"></div>
</body>


<script>
  const conn = new WebSocket('ws://localhost:8080?idTable=<?= $idTable ?>');

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
      const user = '<?php echo addslashes($_SESSION['current_user']); ?>';
      const formattedMessage = `${user} (Mesa <?= $idTable ?>): ${message}`;

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

  function exitChat() {
    // Redirecionar para a página usersTable.php
    window.location.href = 'usersTable.php';
  }
</script>

</html>