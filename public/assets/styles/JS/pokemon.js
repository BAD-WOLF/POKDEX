$(document).ready(function() {
  // Selecionar os botões
  var likeButton = $('[value="like"]');
  var unlikeButton = $('[value="unlike"]');

  // Adicionar evento de clique aos botões
  likeButton.on("click", function(event) {
    event.preventDefault();
    sendRequest("like");
  });

  unlikeButton.on("click", function(event) {
    event.preventDefault();
    sendRequest("unlike");
  });

  // Anular o duplo clique nos botões
  likeButton.on("dblclick", function(event) {
    event.preventDefault();
  });

  unlikeButton.on("dblclick", function(event) {
    event.preventDefault();
  });

  // Função para enviar a requisição Ajax
  function sendRequest(status) {
    $.ajax({
      url: "/likeunlike/" + status,
      method: "GET",
      success: function(response) {
        // A requisição foi bem-sucedida
        console.log(response); // Faça algo com os dados da resposta (por exemplo, exiba no console)

        // Atualizar os valores dos botões com os respectivos valores do JSON
        likeButton.text(" Like: " + response.like);
        unlikeButton.text(" Unlike: " + response.unlike);
      },
      error: function(xhr, status, error) {
        // A requisição falhou
        console.error("Erro na requisição. Status: " + xhr.status);
      }
    });
  }
});

