// Configuração inicial
const mesAno = document.getElementById("mes-ano");
const btnAnterior = document.getElementById("mes-anterior");
const btnProximo = document.getElementById("mes-proximo");

let dataAtual = new Date(2024, 0); // Janeiro de 2024

// Função para atualizar o texto do mês e ano
function atualizarMesAno() {
  const opcoes = { month: "long", year: "numeric" };
  mesAno.textContent = dataAtual.toLocaleDateString("pt-BR", opcoes).replace(/^\w/, c => c.toUpperCase());
}

// Navegar para o mês anterior
btnAnterior.addEventListener("click", () => {
  dataAtual.setMonth(dataAtual.getMonth() - 1);
  atualizarMesAno();
  atualizarTabela(); // Atualizar a tabela com os dados do novo mês
});

// Navegar para o próximo mês
btnProximo.addEventListener("click", () => {
  dataAtual.setMonth(dataAtual.getMonth() + 1);
  atualizarMesAno();
  atualizarTabela(); // Atualizar a tabela com os dados do novo mês
});

// Inicializar com o mês e ano atuais
atualizarMesAno();

// Função fictícia para atualizar a tabela (substitua com a lógica real)
function atualizarTabela() {
  console.log("Atualizando tabela para:", mesAno.textContent);
  // Aqui pode-se implementar lógica para atualizar os dados exibidos
}

