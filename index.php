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
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=">
  <link rel="preconnect" href="https://fonts.googleapis.com">

  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@500&family=Montserrat:wght@100&display=swap"
    rel="stylesheet">
  <link href='https://fonts.googleapis.com/css?family=MedievalSharp' rel='stylesheet'>
  <link rel="stylesheet" href="./css/style.css">
  <link rel="stylesheet" href="./css/menu.css">
  <link rel="stylesheet" href="https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css">

  <title>CHEST RPG</title>
</head>

<body>

  <header class="header">
    <section class="header-container">
      <div class="logo">
        <a href="index.html"><img src="./img/CHEST_RPG__1_-removebg-preview.png" alt="" class="logo-img"></a>
      </div>
      <ul class="menu-buttons">
        <li><a href="index.php">HOME</a></li>
        <li><a href="App/Pages/mesa.php">MESAS</a></li>
        <li><a href="#update">SOBRE</a></li>
        <li><a href="App/Pages/atualizacao.php">NOVIDADES</a></li>
      </ul>
      <?php if (isUserLoggedIn()): ?>
        <div class="login">
          <a href="../Login/logout.php"><box-icon class="box-icon" name='exit' color='#ffffff'></box-icon></a>
        </div>
      <?php else: ?>
        <div class="login">
          <a href="../Login/loginUser.php"><box-icon class="box-icon" name='user' color='#ffffff' type='solid'></box-icon></a>
        </div>
      <?php endif; ?>
    </section>
  </header>
  <div id="puxar"></div>
  <main class="main-content">

    <section class="first-section">

      <div class="logo-text">
        <img src="img/CHEST_RPG__1_-removebg-preview.png" alt="">
      </div>

      <div class="text-button">
        <h1>Rápido, Fácil e Divertido!</h1>
        <button>JOGAR AGORA</button>
      </div>

      <div class="card-container-first">
        <div class="card1">
          <div class="card-content-first">
            <h2>APLICATIVO</h2>
            <p>Explore nosso aplicativo exclusivo projetado para tornar a experiência de RPG de mesa mais acessível e
              envolvente. Com regras e conteúdo personalizado, proporcionando uma experiência de jogo contínua e
              imersiva.</p>
          </div>
        </div>
        <div class="card1">
          <div class="card-content-first">
            <h2>CRIE SUA FICHA</h2>
            <p>Desenvolver sua ficha de personagem nunca foi tão fácil. Nosso sistema simplificado permite que você crie
              uma ficha em poucos passos, selecionando habilidades, características e detalhes essenciais. </p>
          </div>
        </div>
        <div class="card1">
          <div class="card-content-first">
            <h2>MESAS</h2>
            <p>Conecte-se com amigos em mesas existentes ou crie a sua própria jornada épica. Explore diferentes
              campanhas, estilos de jogo e universos, adaptando as mesas de acordo com suas preferências. </p>
          </div>
        </div>
        <div class="card1">
          <div class="card-content-first">
            <h2>DIVERSÕES</h2>
            <p>Desfrute de momentos inesquecíveis com amigos enquanto embarca em aventuras fantásticas. O RPG de mesa
              não é apenas sobre desafios épicos e estratégias inteligentes, mas também sobre a conexão e diversão
              compartilhadas.</p>
          </div>
        </div>
      </div>

    </section>




    <section class="introduction">
      <div class="image-container-introduction">
        <img src="img/Personagens/1.1.jpeg" alt="">
      </div>
      <section class="text-container-introduction">

        <div class="text">
          <div class="text1">
            <h1>Oque é o RPG de mesa?</h1>
          </div>
          <div class="text1">
            <p>O RPG de mesa, ou RPG de papel e caneta, é um jogo que lembra muito os clássicos jogos de tabuleiro,
              porém com possibilidades mais amplas. Um jogo de interpretar papéis. Desenvolver sua ficha de personagem
              nunca foi tão fácil. Nosso sistema simplificado permite que você crie uma ficha em poucos passos,
              selecionando habilidades, características e detalhes essenciais.</p>
          </div>
          <div class="button-introduction">
            <button>SAIBA MAIS</button>
          </div>
        </div>

      </section>

    </section>
    <section class="update" id="update">
      <div class="text-container-update">
        <h1>Sobre Nós</h1>
      </div>

      <div class="text-update">
        <p>

          Bem-vindo à ChestRPG, onde a paixão pelo RPG se encontra com a inovação tecnológica. Somos uma comunidade
          fundada por amantes de aventuras e narrativas incríveis, unidos pelo desejo de criar experiências de jogo
          inesquecíveis.

          Nossa história é marcada pela visão de ultrapassar limites, proporcionando um ambiente online onde a magia do
          role-playing game ganha vida. Desde nossa fundação, trabalhamos arduamente para construir uma comunidade
          acolhedora e uma plataforma tecnologicamente avançada.

          Os valores fundamentais que nos guiam são inovação, comunidade, diversidade e qualidade. Buscamos
          constantemente a excelência, oferecendo um espaço inclusivo que celebra a diversidade e conecta jogadores em
          narrativas envolventes.

          O que nos torna únicos é nossa plataforma versátil, que atende a diversas preferências e estilos de jogo. Seja
          você um fã de fantasia, ficção científica ou horror, a ChestRPG é um lar para todos. Nosso compromisso com a
          comunidade é constante, acreditando que o feedback é a chave para melhorias contínuas.

          Convidamos você a se juntar à ChestRPG, seja você um veterano em busca de novos desafios ou um novato pronto
          para sua primeira aventura. Embarque em jornadas épicas, crie personagens inesquecíveis e faça parte de uma
          comunidade apaixonada que compartilha a mesma sede por histórias extraordinárias. ChestRPG - Onde as aventuras
          ganham vida.</p>
      </div>

    </section>



    <section class="text-gallery">
      <div class="text-container-gallery">
        <h1>CLASSES</h1>
      </div>
    </section>

    <section class="image-gallery">
      <div class="image-container" id="img1">
        <img src="img/Personagens/1.1.jpeg" alt="Imagem 1">
        <p class="image-text">BRUXA</p>
      </div>
      <div class="image-container" id="img2">
        <img src="img/Personagens/2.1.jpeg" alt="Imagem 2">
        <p class="image-text">ELFA</p>
      </div>
      <div class="image-container" id="img1">
        <img src="img/Personagens/3.1.jpeg" alt="Imagem 1">
        <p class="image-text">MÍSTICO</p>
      </div>
      <div class="image-container" id="img2">
        <img src="img/Personagens/4.1.jpeg" alt="Imagem 2">
        <p class="image-text">ESPADACHIN</p>
      </div>
      <div class="image-container" id="img1">
        <img src="img/Personagens/4.2.jpeg" alt="Imagem 1">
        <p class="image-text">LADRÃO</p>
      </div>
    </section>

    <section class="button-gallery">
      <div class="button-container-gallery">
        <button> <a href="App/Pages/classes.php"> EXPLORE MAIS CLASSES </a></button>
      </div>
    </section>
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
          <img src="img/face.svg" alt="">
        </div>
        <div class="image-footer">
          <img src="img/insta.svg" alt="">
        </div>
        <div class="image-footer">
          <img src="img/twitter.svg" alt="">
        </div>
        <div class="image-footer">
          <img src="img/discord.svg" alt="">
        </div>
      </div>

      <div class="logo-footer">
        <a href="index.html"><img src="img/CHEST_RPG__1_-removebg-preview.png" alt="" class="logo-img-footer"></a>
      </div>
      <div class="text-footer">
        <p>© 2022 CHEST RPG. Todos os direitos reservados.</p>
      </div>
    </section>
  </footer>

</body>

</html>