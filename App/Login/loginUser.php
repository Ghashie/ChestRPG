<?php

require_once '../Model/user.php';
require_once '../Model/userDao.php';
require_once '../Model/conn.php';

$email = $password = "";


$user = new \App\Model\User();
$userDao = new \App\Model\UserDao();

if (isset($_POST['search'])) {

  $email = $_POST['email'];
  $password = $_POST['password'];

  $user->setEmailU($email);
  $user->setPasswordU($password);

  $idU = $userDao->search($user);
  if ($idU) {
    if (!isset($_SESSION))
      session_start();
    $_SESSION['idUser'] = $idU;
    $_SESSION['email'] = $user->getEmailU();
    $_SESSION['username'] = $user->getUsernameU();
    header("Location: ../Pages/mesa.php");
  } else {
    echo ("Email ou senha inválidos");
  }
}
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastro</title>
  <link rel="stylesheet" href="../../css/login.css">
</head>

<body>
  <section class="main-content">
    <div class="login">
      <form action="loginUser.php" method="POST">
        <div class="login-screen">
          <div class="login-form">
            <div style="margin-left: 22px;margin-bottom: 22px;margin-top: -9px;">
              <h1>Login</h1>
            </div>
            <section class="control-group-main">
              <div class="control-group">
                <input type="text" class="login-field" name="email" placeholder="Email" id="login-name">
                <label class="user" for="login-name"></label>
              </div>
              <div class="control-group">
                <input type="password" class="login-field" name="password" placeholder="Senha" id="login-pass">
                <label class="key" for="login-pass"></label>
              </div>
            </section>

            <button class="btn btn-primary btn-large btn-block" name="search"><a href="#">Logar-se</a></button>
            <p style="margin-top: 12px;">
              <a class="login-link" href="#">Esqueci minha senha </a>
              <a class="login-link create" href="createUser.php">Crie sua conta</a>
            </p>
          </div>
        </div>
      </form>
    </div>
    </div>
  </section>
</body>

</html>