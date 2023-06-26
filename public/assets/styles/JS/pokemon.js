document.addEventListener('DOMContentLoaded', () => {
  // Código JavaScript
  // Selecione os botões
  var likeButton = document.querySelector('[value="like"]');
  var unlikeButton = document.querySelector('[value="unlike"]');

  // Adicione o evento de clique aos botões
  likeButton.addEventListener('click', function () {
    sendRequest('like');
  });

  unlikeButton.addEventListener('click', function () {
    sendRequest('unlike');
  });

  // Função para enviar a requisição Ajax
  function sendRequest(status) {
    var xhr = new XMLHttpRequest();
    xhr.open('GET', '/likeunlike/' + status, true);

    xhr.onreadystatechange = function () {
      if (xhr.readyState === XMLHttpRequest.DONE) {
        if (xhr.status === 200) {
          // A requisição foi bem-sucedida
          var response = JSON.parse(xhr.responseText);
          console.log(response); // Faça algo com os dados da resposta (por exemplo, exiba no console)

          // Atualize os valores dos botões com os respectivos valores do JSON
          likeButton.textContent = 'Like: ' + response.like;
          unlikeButton.textContent = 'Unlike: ' + response.unlike;
        } else {
          // A requisição falhou
          console.error('Erro na requisição. Status: ' + xhr.status);
        }
      }
    };

    xhr.send();
  }
});
