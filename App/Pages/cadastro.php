<?php
// Inicializar Firebase SDK (certifique-se de que o Firebase já está configurado no seu projeto)
require 'vendor/autoload.php';

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

// Configurar credenciais do Firebase
$serviceAccount = ServiceAccount::fromJsonFile(__DIR__.'/firebase_credentials.json');
$firebase = (new Factory)->withServiceAccount($serviceAccount)->create();

// Inicializar Firebase Authentication
$auth = $firebase->getAuth();

// Processar o formulário de cadastro
if (isset($_POST['submit'])) {
    $nickname = $_POST['nickname'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];
    $confSenha = $_POST['confSenha'];

    // Validar senha
    if ($senha !== $confSenha) {
        echo "As senhas não coincidem.";
    } else {
        // Cadastrar usuário no Firebase Authentication
        try {
            $user = $auth->createUserWithEmailAndPassword($email, $senha, ['displayName' => $nickname]);
            echo "Usuário cadastrado com sucesso: ".$user->uid()."<br>";
        } catch (\Kreait\Firebase\Auth\CreateUser\FailedToCreateUser $e) {
            echo "Erro ao cadastrar usuário: ".$e->getMessage()."<br>";
        }
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
          <div class="login-form">
            <div style="margin-left: 22px;margin-bottom: 22px;margin-top: -9px;">
				<h1>Cadastro</h1>
			</div>
            <section class="control-group-main">
            <div class="control-group">
              <input type="text" class="login-field" value="" placeholder="Usuário"  id="login-name">
              <label class="user" for="login-name"></label>
            </div>

            <div class="control-group">
                <input type="text" class="login-field" value="" placeholder="Email" id="login-name">
                <label class="user" for="login-name"></label>
              </div>
              
              <div class="control-group">
                <input type="password" class="login-field" value="" placeholder="Senha" id="login-pass">
                <label class="key" for="login-pass"></label>
              </div>

            <div class="control-group">
              <input type="password" class="login-field" value="" placeholder="Confirmar senha" id="login-pass">
              <label class="key" for="login-pass"></label>
            </div>
        </section>
            <a class="btn btn-primary btn-large btn-block" href="#">Cadastre-se</a>
			<p style="margin-top: 12px;">
				<a class="login-link create" href="login.html">Entrar em minha conta</a>
			</p>
          </div>
		  		  
        </div>
      </div>
    </section>
</body>

</html>