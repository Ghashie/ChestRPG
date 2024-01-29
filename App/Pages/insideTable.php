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
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="stylesheet" href="../../css/insideTable.css">
  <script src="js/insideTable.js"></script>
  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>


  <title>ChestRPG - <?= $table['nameTable'] ?></title>
</head>

<body>

  <div class="app">
    <header class="header">

      <div class="header-menu">
        <a class="menu-link" onclick="mostrarConteudo('conteudo1')" href="#">Chat</a>
        <a class="menu-link " onclick="mostrarConteudo('conteudo2')" href="#">Fichas</a>
      </div>
      <!--
         <div class="back-site">
          <a href="index.html">voltar ao site</a>
         </div>
      -->
      <div class="header-profile">
        <div class="notification">
          <span class="notification-number">0</span>
          <svg viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-bell">
            <path d="M18 8A6 6 0 006 8c0 7-3 9-3 9h18s-3-2-3-9M13.73 21a2 2 0 01-3.46 0" />
          </svg>
        </div>
        <button onclick="exitChat()" id="exit-button"><box-icon type='solid' name='exit' style="color: #ffffff;"></box-icon></button>
      </div>
    </header>

    <div class="wrapper">
      <div class="left-side">
        <div class="side-titles-container">
          <div class="side-title" onclick="toggleDropdown('fichas-dropdown')">
            Fichas
            <div class="arrow-icon right"></div>
          </div>
          <div class="side-menu" id="fichas-dropdown">
            <a href="#">
              <svg viewBox="0 0 512 512">
                <path d="M0 0h128v128H0zm0 0M192 0h128v128H192zm0 0M384 0h128v128H384zm0 0M0 192h128v128H0zm0 0" fill="currentColor" />
              </svg>
              Adicionar Fichas
            </a>
            <a href="#">
              <svg viewBox="0 0 488.932 488.932" fill="currentColor">
                <path d="M243.158 61.361v-57.6c0-3.2 4-4.9 6.7-2.9l118.4 87c2 1.5 2 4.4 0 5.9l-118.4 87c-2.7 2-6.7.2-6.7-2.9v-57.5c-87.8 1.4-158.1 76-152.1 165.4 5.1 76.8 67.7 139.1 144.5 144 81.4 5.2 150.6-53 163-129.9 2.3-14.3 14.7-24.7 29.2-24.7 17.9 0 31.8 15.9 29 33.5-17.4 109.7-118.5 192-235.7 178.9-98-11-176.7-89.4-187.8-187.4-14.7-128.2 84.9-237.4 209.9-238.8z" />
              </svg>
              Editar Fichas
            </a>
          </div>
        </div>

        <div class="side-titles-container">
          <div class="side-title2" onclick="toggleDropdown('chat-dropdown')">
            Chat
            <div class="arrow-icon right"></div>
          </div>
          <div class="side-menu" id="chat-dropdown">
            <a href="#">
              <svg viewBox="0 0 512 512" fill="currentColor">
                <!-- Adicione o caminho do ícone -->

              </svg>
              Chat Global
            </a>
            <a href="#">
              <svg viewBox="0 0 512 512" fill="currentColor">
                <!-- Adicione o caminho do ícone -->
              </svg>
              Chat Privado
            </a>
          </div>
        </div>

        <div class="side-titles-container">
          <div class="side-title3" onclick="toggleDropdown('membros-dropdown')">
            Membros
            <div class="arrow-icon right"></div>
          </div>
          <div class="side-menu" id="membros-dropdown">
            <a href="#">
              <svg viewBox="0 0 512 512" fill="currentColor">
                <!-- Adicione o caminho do ícone -->
              </svg>
              Membro 1</a>
            <a href="#">
              <svg viewBox="0 0 512 512" fill="currentColor">
                <!-- Adicione o caminho do ícone -->
              </svg>
              Membro 2</a>
          </div>
        </div>
      </div>

      <div class="main-container">
        <div class="chat conteudo" id="conteudo1">
          <div class="chat-title">
            <h1>Mesa: <?= $table['nameTable'] ?></h1>
            <h2>ChestRPG</h2>
          </div>

          <div id="message-container">
            <!-- Aqui serão exibidas as mensagens do chat -->
          </div>
          <form>
            <div class="message-box">
              <textarea type="text" id="message-input" class="message-input" placeholder="Digite aqui..."></textarea>
              <button id="send-button" class="message-submit" onclick="sendMessage()">Enviar</button>
            </div>
          </form>
        </div>
      </div>

      <div class="bg"></div>
      <div class="conteudo" id="conteudo2">
        <h2>Conteúdo do Botão 2</h2>
        <p>Este é o conteúdo associado ao Botão 2.</p>
      </div>

      <div class="conteudo" id="conteudo3">
        <h2>Conteúdo do Botão 3</h2>
        <p>Este é o conteúdo associado ao Botão 3.</p>
      </div>

      <div class="bg"></div>

    </div>
  </div>
  </div>
  <div class="overlay-app"></div>
</body>


<script>
  const conn = new WebSocket('ws://localhost:8080?idTable=<?= $idTable ?>');

  conn.onopen = function(event) {
    console.log('Conexão WebSocket aberta');
  };

  conn.onmessage = function(event) {
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