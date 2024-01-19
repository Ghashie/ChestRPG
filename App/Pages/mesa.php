<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@500&display=swap" rel="stylesheet">
    <title>Mesas</title>
    <link rel="stylesheet" href="style.css">
    <script src="script.js"></script>
</head>
<body>
    <header class="header">

        <div class="logo">
         <a href="index.html"><img src="Chest_RPG_NoBackGround.png" alt="" class="logo-img"></a> 
        </div>
        <div class="container">
          <button class="btn">Home</button>
          <button class="btn">Sobre</button>
          <div class="dropdown">
            <button class="dropdown-button">Mesas </button>
            <div class="dropdown-content">
              <a href="#">Criar mesa</a>
              <a href="#">Entrar em mesa existente</a>
            </div>
          </div>
          <button class="btn">Atualizações</button>
        </div>
        <div class="login">Login</div>
      </header>

      <main class="main-content">

        <div class="content-button-left">
    <button id="openModalBtn" class="button"> Crie sua mesa</button>
    <div id="myModal" class="modal">
      <div class="modal-content">
        <span class="close" id="closeModalBtn">&times;</span>
   
<div class="modal-logo-main"><img class="modal-logo" src="../img/logo.png" alt=""></div>
<div class="main-text-modal"> <h1>Crie sua mesa</h1></div>

        <section class="control-group-main">

          <div class="control-group">
              <input type="text" class="login-field" value="" placeholder="Nome da mesa" id="login-name">
              <label class="user" for="login-name"></label>
            </div>
            

            <div class="control-group">
              <input type="text" class="login-field" value="" placeholder="Descricão da mesa" id="login-name">
              <label class="user" for="login-name"></label>
            </div>

            <div class="control-group">
              <input type="password" class="login-field" value="" placeholder="Senha da mesa" id="login-pass">
              <label class="key" for="login-pass"></label>
            </div>
            
            <div>
              <div class="modal-button-main">
              <button class="modal-button"><i class="animation"></i>Criar mesa<i class="animation"></i>
              </button>
            </div>
          </div>

      </section>
    

      </div>
    </div>
</div>

<div class="content-button-right">
    <button class="button">Entre em uma mesa</button>
</div>

</main>

    
</body>
</html>