<?php
session_start();

function isUserLoggedIn() {
    return isset($_SESSION['idUser']);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
  <link rel="stylesheet" href="../../css/atualizacao.css">
  <link rel="stylesheet" href="../../css/menu.css">
  <link href='https://fonts.googleapis.com/css?family=MedievalSharp' rel='stylesheet'>
  
</head>

<body>
<header class="header">
    <section class="header-container">
      <div class="logo">
        <a href="index.html"><img src="../../img/CHEST_RPG__1_-removebg-preview.png" alt="" class="logo-img"></a>
      </div>
      <ul class="menu-buttons">
        <li><a href="../../index.php">HOME</a></li>
        <li><a href="mesa.php">MESAS</a></li>
        <li><a href="../../index.php#update">SOBRE</a></li>
        <li><a href="atualizacao.php">NOVIDADES</a></li>
      </ul>
      <?php if (isUserLoggedIn()) : ?>
        <div class="login">
          <a href="../Login/logout.php"><box-icon class="box-icon" name='exit' color='#ffffff'></box-icon></a>
        </div>
      <?php else : ?>
        <div class="login">
          <a href="../Login/loginUser.php"><box-icon class="box-icon" name='user' color='#ffffff'></box-icon></a>
        </div>
      <?php endif; ?>
    </section>
  </header>



  <main class="update-section">
        <h1 class="title">Atualização Patch 1.0</h1>
    
        <h3 class="subtitle">Novidades</h3>
        <p class="content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ultrices, justo at egestas imperdiet, lorem dolor luctus metus.</p>
    
        <h3 class="subtitle">Melhorias</h3>
        <ul class="list">
          <li class="item">Lorem ipsum 1</li>
          <li class="item">Lorem ipsum 2</li>
          <li class="item">Lorem ipsum 3</li>
        </ul>
    
        <h3 class="subtitle">Correções</h3>
        <p class="content">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Nunc ultrices, justo at egestas imperdiet, lorem dolor luctus metus.</p>
    
        <h3 class="subtitle">Outras melhorias</h3>
        <ul class="list">
          <li class="item">Lorem ipsum 4</li>
          <li class="item">Lorem ipsum 5</li>
        </ul>
    </main>

  <footer class="footer">
    <section class="first-footer">
      <div class="text-first-footer">
        <h1>SOBRE O CHEST RPG</h1>
      </div>
      <div class="text-first-footer">
        <h1>BAIXE NOSSO APLICATIVO</h1>
      </div>
      <div class="text-first-footer">
        <h1>DEIXE O SEU FEEDBACK</h1>
      </div>
      <div class="text-first-footer">
        <h1>SUPORTE</h1>
      </div>

    </section>

    <section class="second-footer">
      <div class="image-second-footer">
        <div class="image-footer">
          <img src="../../img/face.svg" alt="">
        </div>
        <div class="image-footer">
          <img src="../../img/insta.svg" alt="">
        </div>
        <div class="image-footer">
          <img src="../../img/twitter.svg" alt="">
        </div>
        <div class="image-footer">
          <img src="../../img/discord.svg" alt="">
        </div>
      </div>

      <div class="logo-footer">
        <a href="index.html"><img src="../../img/CHEST_RPG__1_-removebg-preview.png" alt="" class="logo-img-footer"></a>
      </div>
      <div class="text-footer">
        <p>© 2022 CHEST RPG. Todos os direitos reservados.</p>
      </div>
    </section>
  </footer>





</body>

</html>