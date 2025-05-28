 // Adicione este código no início do script para ocultar o formulário ao carregar a página
 document.addEventListener("DOMContentLoaded", function () {
    document.querySelector(".form-container").style.display = "none";
    document.getElementById("update-form-container").style.display = "none";
  });

  function abrirModal() {
    document.querySelector(".form-container").style.display = "flex";
  }

  document.getElementById("close-btn").addEventListener("click", function () {
    document.querySelector(".form-container").style.display = "none";
  });

  document.getElementById("cancel-btn").addEventListener("click", function () {
    document.querySelector(".form-container").style.display = "none";
  });

  // Abrir Modal de Atualização ao Clicar no Ícone de Edição
  document.querySelectorAll(".edit-btn").forEach(button => {
    button.addEventListener("click", function (event) {
      event.preventDefault(); // Evita a navegação padrão

      // Pegando os dados do botão clicado
      const id_usuario = this.getAttribute("data-id_usuario");
      const id = this.getAttribute("data-id");
      const valor = this.getAttribute("data-valor");
      const categoria = this.getAttribute("data-categoria");
      const tipoReceita = this.getAttribute("data-tipoReceita");
      const data_registro = this.getAttribute("data-data_registro");
      const numParcelas = this.getAttribute("data-numParcelas");
      const pago = this.getAttribute("data-pago") === "1"; // Converte string para booleano

      // Preenchendo os campos do formulário
      document.getElementById("update-id_usuario").value = id_usuario;
      document.getElementById("update-id").value = id;
      document.getElementById("update-valor").value = valor;
      document.getElementById("update-categoria").value = categoria;
      document.getElementById("update-data_registro").value = data_registro;
      document.getElementById("update-numParcelas").value = numParcelas;
      document.getElementById("update-pago").checked = pago;

      

      // Exibir o modal de atualização
      document.getElementById("update-form-container").style.display = "flex";
    });
  });

  // Fechar Modal de Atualização
  document.getElementById("close-update-btn").addEventListener("click", function () {
    document.getElementById("update-form-container").style.display = "none";
  });

  document.getElementById("cancel-update-btn").addEventListener("click", function () {
    document.getElementById("update-form-container").style.display = "none";
  });

  // Controlando as receitas por mês
  document.addEventListener("DOMContentLoaded", function () {
    let hoje = new Date();
    let mesAtual = hoje.getMonth(); // 0 = Janeiro, 1 = Fevereiro, etc
    let anoAtual = hoje.getFullYear();

    const nomeMes = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
                     "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

    function atualizarTabela() {
      const linhas = document.querySelectorAll("tbody tr");

      linhas.forEach(linha => {
        const anoLinha = parseInt(linha.getAttribute("data-ano"));
        const mesLinha = parseInt(linha.getAttribute("data-mes")) - 1; // porque JavaScript começa o mês em 0

        if (anoLinha === anoAtual && mesLinha === mesAtual) {
          linha.style.display = ""; // Mostra
        } else {
          linha.style.display = "none"; // Esconde
        }
      });

      // Atualiza o título acima da tabela
      document.getElementById("mes-ano").textContent = `${nomeMes[mesAtual]} ${anoAtual}`;
      
      // Atualiza os valores dos cards de resumo
      atualizarCardsMes(mesAtual + 1, anoAtual); // +1 porque mês no JS começa em 0, mas no PHP começa em 1
    }
    
    // Função para atualizar os cards de resumo via AJAX
    function atualizarCardsMes(mes, ano) {
      // Criar um objeto FormData para enviar os dados
      const formData = new FormData();
      formData.append('mes', mes);
      formData.append('ano', ano);
      
      // Fazer uma requisição AJAX para buscar os novos valores
      fetch('buscarValoresMes.php', {
        method: 'POST',
        body: formData
      })
      .then(response => response.json())
      .then(data => {
        // Atualizar os valores nos cards
        document.querySelector('.card:nth-child(1) p').textContent = 
          'R$ ' + data.pendentes.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        
        document.querySelector('.card:nth-child(2) p').textContent = 
          'R$ ' + data.recebidas.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, ".");
        
        document.querySelector('.card:nth-child(3) p').textContent = 
          'R$ ' + data.total.replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      })
      .catch(error => {
        console.error('Erro ao buscar dados:', error);
      });
    }

    document.getElementById("mes-anterior").addEventListener("click", function () {
      mesAtual--;
      if (mesAtual < 0) {
        mesAtual = 11;
        anoAtual--;
      }
      atualizarTabela();
    });

    document.getElementById("mes-proximo").addEventListener("click", function () {
      mesAtual++;
      if (mesAtual > 11) {
        mesAtual = 0;
        anoAtual++;
      }
      atualizarTabela();
    });

    // Primeira atualização ao carregar
    atualizarTabela();
  });