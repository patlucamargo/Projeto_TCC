// Script de controle para tela de despesas
document.addEventListener("DOMContentLoaded", function () {
  document.querySelector(".form-container").style.display = "none";
  document.getElementById("update-form-container").style.display = "none";
});

// Função para abrir o modal de nova despesa
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
    event.preventDefault();

    // Pegar os dados do botão clicado
    const id_usuario = this.getAttribute("data-id_usuario");
    const id = this.getAttribute("data-id");
    const valor = this.getAttribute("data-valor");
    const categoria = this.getAttribute("data-categoria");
    const tipoDespesa = this.getAttribute("data-tipoDespesa");
    const descricao = this.getAttribute("data-descricao");
    const dataVenc = this.getAttribute("data-dataVenc");
    const pago = this.getAttribute("data-pago") === "1";

    // Preencher os campos do formulário
    document.getElementById("update-id_usuario").value = id_usuario;
    document.getElementById("update-id").value = id;
    document.getElementById("update-valor").value = valor;
    document.getElementById("update-categoria").value = categoria;
    
    // Corrigir o preenchimento dos radio buttons
    const radioIndividual = document.querySelector('input[name="tipoDespesa"][value="individual"]');
    const radioGrupo = document.querySelector('input[name="tipoDespesa"][value="grupo"]');
    
    if (tipoDespesa === "individual") {
      radioIndividual.checked = true;
    } else {
      radioGrupo.checked = true;
    }
    
    document.getElementById("update-descricao").value = descricao;
    document.getElementById("update-dataVenc").value = dataVenc;
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

// Controlando as despesas por mês
document.addEventListener("DOMContentLoaded", function () {
  let hoje = new Date();
  let mesAtual = hoje.getMonth();
  let anoAtual = hoje.getFullYear();

  const nomeMes = ["Janeiro", "Fevereiro", "Março", "Abril", "Maio", "Junho",
    "Julho", "Agosto", "Setembro", "Outubro", "Novembro", "Dezembro"];

  function atualizarTabela() {
    const linhas = document.querySelectorAll("tbody tr");
    let linhasVisiveis = 0;

    linhas.forEach(linha => {
      const anoLinha = parseInt(linha.getAttribute("data-ano"));
      const mesLinha = parseInt(linha.getAttribute("data-mes")) - 1; // JS começa mês em 0

      if (anoLinha === anoAtual && mesLinha === mesAtual) {
        linha.style.display = ""; // Mostra
        linhasVisiveis++;
      } else {
        linha.style.display = "none"; // Esconde
      }
    });

    // Atualiza o título acima da tabela
    document.getElementById("mes-ano").textContent = `${nomeMes[mesAtual]} ${anoAtual}`;

    // Atualiza os valores dos cards de resumo
    atualizarCardsMes(mesAtual + 1, anoAtual); // +1 porque PHP começa mês em 1
    
    // Log para debug
    console.log(`Mês: ${mesAtual + 1}, Ano: ${anoAtual}, Linhas visíveis: ${linhasVisiveis}`);
  }

  // Função para atualizar os cards via AJAX
  function atualizarCardsMes(mes, ano) {
    const formData = new FormData();
    formData.append('mes', mes);
    formData.append('ano', ano);

    fetch('buscarValoresDespesaMes.php', {
      method: 'POST',
      body: formData
    })
      .then(response => {
        if (!response.ok) {
          throw new Error('Network response was not ok');
        }
        return response.json();
      })
      .then(data => {
        console.log('Dados recebidos:', data); // Log para debug
        
        // Atualizar os valores nos cards
        document.querySelector('.card:nth-child(1) p').textContent =
          'R$ ' + parseFloat(data.pendentes || 0).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        document.querySelector('.card:nth-child(2) p').textContent =
          'R$ ' + parseFloat(data.recebidas || 0).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, ".");

        document.querySelector('.card:nth-child(3) p').textContent =
          'R$ ' + parseFloat(data.total || 0).toFixed(2).replace('.', ',').replace(/\B(?=(\d{3})+(?!\d))/g, ".");
      })
      .catch(error => {
        console.error('Erro ao buscar dados:', error);
        
      });
  }

  // Configurar os botões de navegação de mês
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