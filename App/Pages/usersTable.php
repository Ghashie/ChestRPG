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

if (isset($_SESSION['idUser'])) {
  if (!isset($_SESSION['idUser'])) {
    header("Location: ../Login/loginUser.php");
    exit();
  }

  function isUserLoggedIn()
  {
    return isset($_SESSION['idUser']);
  }

  $_SESSION['idUser']->getIdU();

  if (!isset($_SESSION['idUser'])) { // Verificar se o usuário está logado
    header("Location: ../Login/loginUser.php"); // Se não estiver logado, redirecione para a página de login
    exit();
  }

  $tableDao = new \App\Model\TablesDao();
  $participatingTables = $tableDao->getTablesByUserId($_SESSION['idUser']->getIdU());

  // Verificar se o formulário de criação de mesa foi enviado
  if (isset($_POST['create'])) {
    $tableName = $_POST['name'];
    $tableDescription = $_POST['description'];
    $password = $_POST['password'];
    // Obter o ID do usuário logado
    $idUser = $_SESSION['idUser'];

    $table = new \App\Model\Tables();  // Criar uma instância da tabela e definir os valores
    $table->setIdFK($idUser);
    $table->setNameT($tableName);
    $table->setDescriptionT($tableDescription);
    $table->setPasswordT($password);


    $tableDao = new \App\Model\TablesDao(); // Criar uma instância do TableDao
    $tableDao->create($table); // Chamar a função create no TableDao
    header("Location: insideTable.php?idTable=" . $table->getIdT());
    exit();
  }

  if (isset($_POST['join'])) {
    $joinCode = $_POST['code'];
    $idUser = $_SESSION['idUser'];

    $tableDao = new \App\Model\TablesDao();
    $tableData = $tableDao->getTableByCode($joinCode);

    if ($tableData) {
      // Mesa encontrada, agora você pode associar o usuário à mesa na tabela members
      $membersDao = new \App\Model\MembersDao();
      $member = new \App\Model\Members();
      $member->setIdUM($idUser);
      $member->setIdTM($tableData['idTable']);
      $member->setIsAdmin(false);  // Defina como desejado, neste exemplo é nulo.

      $membersDao->join($member);

      // Redirecione ou faça qualquer outra coisa após o usuário se juntar à mesa
      header("Location: insideTable.php?idTable=" . $tableData['idTable']);
      exit();
    } else {
      // Mesa não encontrada, adicione a lógica apropriada (ex: exiba uma mensagem de erro)
      echo "Mesa não encontrada.";
    }
  }

  if (isset($_POST['confirmEdit'])) {
    $table = new \App\Model\Tables();
    $table->setIdT($_POST['TableId']);
    $table->setNameT($_POST['TableName']);
    $table->setDescriptionT($_POST['TableDescription']);
    $tableDao = new \App\Model\TablesDao();
    $tableDao->editTable($table);
    header("Location: usersTable.php");
    exit();
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Mesas</title>
  <link rel="stylesheet" href="css/usersTable.css">
  <link rel="stylesheet" href="../../css/menu.css">
  <script src="https://unpkg.com/boxicons@2.1.4/dist/boxicons.js"></script>
  <script src="js/mesa.js"></script>
</head>

<body>
  <header class="header">
    <section class="header-container">
      <div class="logo">
        <a href="../../index.php"><img src="../../img/CHEST_RPG__1_-removebg-preview.png" alt="" class="logo-img"></a>
      </div>
      <ul class="menu-buttons">
        <li><a href="../../index.php">HOME</a></li>
        <li><a href="mesa.php">MESAS</a></li>
        <li><a href="../../index.php#update">SOBRE</a></li>
        <li><a href="">NOVIDADES</a></li>
      </ul>
      <?php if (isUserLoggedIn()): ?>
        <div class="login">
          <a href="../Login/logout.php"><box-icon class="box-icon" name='exit' color='#ffffff'></box-icon></a>
        </div>
      <?php else: ?>
        <div class="login">
          <a href="../Login/loginUser.php"><box-icon class="box-icon" name='user' color='#ffffff'></box-icon></a>
        </div>
      <?php endif; ?>
    </section>
  </header>

  <section class="buttons-users-table">
    <button id="openModalBtn" class="button">Crie uma mesa</button>
    <div id="myModal" class="modal">
      <div class="modal-content">
        <span class="close" id="closeModalBtn">&times;</span>

        <div class="modal-logo-main"><img class="modal-logo" src="../img/logo.png" alt=""></div>
        <div class="main-text-modal">
          <h1>Crie sua mesa</h1>
        </div>
        <form action="usersTable.php" method="POST">
          <section class="control-group-main">
            <div class="control-group">
              <input type="text" class="login-field" name="name" placeholder="Nome da mesa" id="login-name">
              <label class="user" for="login-name"></label>
            </div>


            <div class="control-group">
              <input type="text" class="login-field" name="description" placeholder="Descricão da mesa" id="login-name">
              <label class="user" for="login-name"></label>
            </div>

            <div class="control-group">
              <input type="password" class="login-field" name="password" placeholder="Senha da mesa" id="login-pass">
              <label class="key" for="login-pass"></label>
            </div>

            <div>
              <div class="modal-button-main">
                <button class="modal-button" type="submit" name="create"><i class="animation"></i>Criar mesa<i
                    class="animation"></i>
                </button>
              </div>
            </div>
          </section>
        </form>
      </div>
    </div>

    <button id="openJoinModalBtn" class="button">Entre em uma mesa</button>
    <div id="myModal" class="modal">
      <div class="modal-content">
        <span class="close" id="closeModalBtn">&times;</span>

        <div class="modal-logo-main"><img class="modal-logo" src="../img/logo.png" alt=""></div>
        <div class="main-text-modal">
          <h1>Crie sua mesa</h1>
        </div>
        <form action="usersTable.php" method="POST">
          <section class="control-group-main">
            <div class="control-group">
              <input type="text" class="login-field" name="name" placeholder="Nome da mesa" id="login-name">
              <label class="user" for="login-name"></label>
            </div>


            <div class="control-group">
              <input type="text" class="login-field" name="description" placeholder="Descricão da mesa" id="login-name">
              <label class="user" for="login-name"></label>
            </div>

            <div class="control-group">
              <input type="password" class="login-field" name="password" placeholder="Senha da mesa" id="login-pass">
              <label class="key" for="login-pass"></label>
            </div>

            <div>
              <div class="modal-button-main">
                <button class="modal-button" type="submit" name="create"><i class="animation"></i>Criar mesa<i
                    class="animation"></i>
                </button>
              </div>
            </div>
          </section>
        </form>
      </div>
    </div>
  </section>

  <main class="main-content">
    <div class="text-users-table">
      <h1>SUAS MESAS</h1>
    </div>

    <div class="container-buttons">
      <div class="row">
        <?php foreach ($participatingTables as $table): ?>
          <div class="col-md-6">
            <div class="button" href="insideTable.php?idTable=<?= $table['idTable'] ?>">
              <div class="tableCode">
                <p>
                  <?= $table['codeTable'] ?>
                </p>
              </div>

              <div class="tableName">
                <h2>
                  <?= $table['nameTable'] ?>
                </h2>
              </div>

              <div class="tableDescription">
                <p>
                  <?= $table['descriptionTable'] ?>
                </p>
              </div>

              <div class="tableButtons">
                <?php if ($_SESSION['idUser']->getIdU() == $table['idAdmin']): ?>
                  <!-- Botões para o admin -->
                  <button id="openEditModalBtn" value="<?= $table['idTable'] ?>" type="button">EDITAR</button>
                  <form method="POST" action="delete.php"
                    onsubmit="return confirm('Tem certeza que deseja excluir esta mesa?');" style="display:inline;">
                    <input type="hidden" name="delete" value="<?= $table['idTable'] ?>">
                    <button type="submit">EXCLUIR</button>
                  </form>
                <?php else: ?>
                  <!-- Botão para membros -->
                  <form method="POST" action="exit.php"
                    onsubmit="return confirm('Tem certeza que deseja sair desta mesa?');" style="display:inline;">
                    <input type="hidden" name="exit" value="<?= $table['idTable'] ?>">
                    <button class="exit-button" type="submit">SAIR</button>
                  </form>
                <?php endif; ?>
              </div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </div>
  </main>

  <!-- Modal de Edição -->
  <div id="editModal" class="modal">
    <div class="modal-content">
      <span class="close" id="closeEditModalBtn">&times;</span>

      <div class="modal-logo-main"><img class="modal-logo" src="../img/logo.png" alt=""></div>
      <div class="main-text-modal">
        <h1>Atualize sua mesa</h1>
      </div>
      <form action="usersTable.php" method="POST">
        <section class="control-group-main">
          <input type="hidden" name="TableId" value="<?= $table['idTable'] ?>">
          <div class="control-group">
            <input type="text" class="login-field" name="TableName" placeholder="<?php echo $table['nameTable']; ?>"
              id="login-name">
            <label class="user" for="login-name"></label>
          </div>

          <div class="control-group">
            <input type="text" class="login-field" name="TableDescription"
              placeholder="<?php echo $table['descriptionTable']; ?>" id="login-name">
            <label class="user" for="login-name"></label>
          </div>

          <div>
            <div class="modal-button-main">
              <button class="modal-button" type="submit" name="confirmEdit"><i class="animation"></i>Atualizar<i
                  class="animation"></i>
              </button>
            </div>
          </div>
        </section>
      </form>
    </div>
  </div>
</body>

</html>