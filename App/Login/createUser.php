<?php

$username = $email = $password = $confpassword = "";

if (isset($_POST["record"])) {

  require_once '../Model/conn.php';
  require_once '../Model/user.php';
  require_once '../Model/userDao.php';

  $username = $_POST['username'];
  $email = $_POST['email'];
  $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

  
    $user = new \App\Model\User();
    $user->setUsernameU($username);
    $user->setEmailU($email);
    $user->setPasswordU($password);
    $userDao = new \App\Model\UserDao();
    if ($userDao->create($user)) {
      echo ("Email já cadastrado");
    } else {
      echo ("Cadastrado com sucesso");
      header("Location: loginUser.php");
    }
  }

?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Cadastrar</title>
  <link rel="stylesheet" href="../../css/cadastro.css">
</head>

<body>
  <section class="main-content">
    <div class="login">
      <div class="login-screen">
        <form action="createUser.php" method="POST">
          <div class="login-form">
            <div style="margin-left: 22px;margin-bottom: 22px;margin-top: -9px;">
              <h1>Cadastro</h1>
            </div>
            <section class="control-group-main">
              <div class="control-group">
                <input type="text" class="login-field" name="username" placeholder="Usuário" id="login-name">
                <label class="user" for="login-name"></label>
              </div>

              <div class="control-group">
                <input type="text" class="login-field" name="email" placeholder="Email" id="login-name">
                <label class="user" for="login-name"></label>
              </div>

              <div class="control-group">
                <input type="password" class="login-field" name="password" placeholder="Senha" id="login-pass">
                <label class="key" for="login-pass"></label>
              </div>

              <div class="control-group">
                <input type="password" class="login-field" name="confpassword" placeholder="Confirmar senha"
                  id="login-pass">
                <label class="key" for="login-pass"></label>
              </div>
            </section>
            <button type="submit" name="record" class="btn btn-primary btn-large btn-block"><a href="">Cadastre-se</a></button>
            <p style="margin-top: 12px;">
              <a class="login-link create" href="loginUser.php">Entrar em minha conta</a>
            </p>
          </div>
        </form>
      </div>
    </div>
  </section>
</body>

</html>