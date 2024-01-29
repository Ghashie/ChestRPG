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


//CHAT

document.addEventListener("DOMContentLoaded", function() {
  // Recupera as mensagens do armazenamento local
  var messagesArray = JSON.parse(localStorage.getItem('chatMessages')) || [];

  // Função para enviar a mensagem
  function sendMessage() {
    var messageInput = document.getElementById('message-input');
    var messageContent = messageInput.value.trim();

    if (messageContent !== '') {
      // Cria um objeto de mensagem e adiciona ao array
      var newMessage = {
        content: messageContent,
        type: 'personal'  // Adicione outros tipos de mensagem se necessário
      };

      messagesArray.push(newMessage);

      // Salva as mensagens no armazenamento local
      localStorage.setItem('chatMessages', JSON.stringify(messagesArray));

      // Renderiza as mensagens
      renderMessages();

      // Limpa o campo de entrada após o envio
      messageInput.value = '';
    }
  }

  // Função para renderizar as mensagens
  function renderMessages() {
    var messagesContent = document.querySelector('.messages-content');

    // Limpa o conteúdo atual
    messagesContent.innerHTML = '';

    // Adiciona cada mensagem ao conteúdo das mensagens
    messagesArray.forEach(message => {
      var newMessage = document.createElement('div');
      newMessage.className = 'message';

      // Define a classe com base no tipo de mensagem (pessoal ou outra)
      newMessage.classList.add(message.type === 'personal' ? 'message-personal' : '');

      newMessage.textContent = message.content;
      messagesContent.appendChild(newMessage);
    });

    // Rola para a última mensagem enviada
    document.querySelector('.messages').scrollTop = messagesContent.scrollHeight;
  }

  // Adiciona um evento de clique ao botão de envio
  document.getElementById('send-button').addEventListener('click', function() {
    sendMessage();
  });

  // Adiciona um evento de pressionar Enter no campo de entrada
  document.getElementById('message-input').addEventListener('keypress', function(event) {
    if (event.which === 13) {
      sendMessage();
      event.preventDefault(); // Impede quebra de linha ao pressionar Enter
    }
  });

  // Chama a função para renderizar as mensagens ao carregar a página
  renderMessages();
});

// Exemplo de como você pode usar as funções
document.addEventListener("DOMContentLoaded", function() {
  // ...

  // Chama a função para acessar todas as mensagens
  var allMessages = getAllMessages();
  console.log('Todas as mensagens:', allMessages);

  // Chama a função para apagar todas as mensagens (por exemplo, ao clicar em um botão)
  document.getElementById('clear-messages-button').addEventListener('click', function() {
    clearAllMessages();
  });

  // ...
});

document.addEventListener("DOMContentLoaded", function() {
  // Função para apagar uma mensagem específica
  function deleteMessage(index) {
    // Remove a mensagem do array de mensagens
    messagesArray.splice(index, 1);

    // Salva as mensagens atualizadas no armazenamento local
    localStorage.setItem('chatMessages', JSON.stringify(messagesArray));

    // Renderiza as mensagens atualizadas
    renderMessages();
  }
});



document.addEventListener("DOMContentLoaded", function() {
  function getMessages() {
    // Fazer uma requisição AJAX para o servidor para obter novas mensagens
    // Use a mesma estrutura do back-end para garantir compatibilidade
    // Atualize a lógica conforme necessário
    fetch('/api/messages')
      .then(response => response.json())
      .then(messages => {
        // Adicione as mensagens recebidas ao conteúdo das mensagens
        messages.forEach(message => {
          var newMessage = document.createElement('div');
          newMessage.className = 'message';
          newMessage.textContent = message.content;

          document.querySelector('.messages-content').appendChild(newMessage);

          // Role para a última mensagem recebida
          document.querySelector('.messages').scrollTop = document.querySelector('.messages-content').scrollHeight;
        });
      })
      .catch(error => console.error('Erro ao buscar mensagens:', error));
  }

  // Atualize as mensagens automaticamente a cada 5 segundos (por exemplo)
  setInterval(getMessages, 5000);
});







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
