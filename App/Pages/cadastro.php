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
</head>

<body>
  <h2>Cadastro</h2>
  <form action="cadastro.php" method="post">
    <label for="nickname">Nickname:</label>
    <input type="text" id="nickname" name="nickname" required><br>

    <label for="email">E-mail:</label>
    <input type="email" id="email" name="email" required><br>

    <label for="senha">Senha:</label>
    <input type="password" id="senha" name="senha" required><br>

    <label for="confSenha">Confirmar Senha:</label>
    <input type="password" id="confSenha" name="confSenha" required><br>

    <button type="submit" name="submit">Cadastrar</button>
  </form>

  <button onclick="loginWithGoogle()">Login com Google</button>

  <script>
    function loginWithGoogle() {
      // Implementar lógica de login com Google usando Firebase
      alert("Implemente a lógica de login com Google aqui.");
    }
  </script>
</body>

</html>