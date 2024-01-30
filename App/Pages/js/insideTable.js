//CASO ESTEJA DANDO CONFLITO, RESETE O CODIGO JS NO DONTPAD: https://dontpad.com/projetoPKTHRY
// DPS APAGUE OS CODIGOS COMENTADOS PARA REMOVER NO HTML (121) e CSS (1258)

var conteudoAtual = 'conteudo1';

function mostrarConteudo(idConteudo) {
  // Oculta todos os conteúdos
  var todosConteudos = document.getElementsByClassName('conteudo');
  for (var i = 0; i < todosConteudos.length; i++) {
    todosConteudos[i].style.display = 'none';
  }

  // Mostra apenas o conteúdo associado ao botão clicado
  document.getElementById(idConteudo).style.display = 'block';

  // Atualiza o conteúdo atual
  conteudoAtual = idConteudo;

  // Verifica se o conteúdo atual é o chat e ajusta a posição da caixa de entrada
  if (conteudoAtual === 'conteudo1') {
    ajustarPosicaoCaixaDeEntrada();
  }
}

function ajustarPosicaoCaixaDeEntrada() {
  // Lógica para ajustar a posição da caixa de entrada, se necessário
  var messageBox = document.querySelector('.message-box');
  
  // Verifica se o conteúdo atual é o chat
  if (conteudoAtual === 'conteudo1') {
    messageBox.style.position = 'absolute'; // Ou 'absolute' dependendo do layout desejado
    messageBox.style.top = 'auto';
    messageBox.style.bottom = '0';
  } else {
    // Se não for o chat, ajuste conforme necessário para outros conteúdos
    messageBox.style.position = 'static'; // Ou qualquer outra propriedade que seja apropriada
  }
}


window.onload = function() {
  var todosConteudos = document.getElementsByClassName('conteudo');
  for (var i = 1; i < todosConteudos.length; i++) {
    todosConteudos[i].style.display = 'none';
  }

  // Chama a função para ajustar a posição da caixa de entrada
  ajustarPosicaoCaixaDeEntrada();
};


function scrollToBottom() {
  var messagesContainer = document.querySelector('.messages');
  messagesContainer.scrollTop = messagesContainer.scrollHeight;
}


function toggleDropdown(dropdownId) {
  var dropdown = document.getElementById(dropdownId);
  var arrowIcon = document.querySelector(`#${dropdownId} .arrow-icon`);

  if (dropdown.style.display === 'none' || dropdown.style.display === '') {
      dropdown.style.display = 'flex';
      arrowIcon.classList.remove('right');
      arrowIcon.classList.add('down');
  } else {
      dropdown.style.display = 'none';
      arrowIcon.classList.remove('down');
      arrowIcon.classList.add('right');
  }
}
