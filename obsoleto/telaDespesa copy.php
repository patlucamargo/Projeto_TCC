<?php
session_start();
include("config.php");

if ((!isset($_SESSION['login']) == true) and (!isset($_SESSION['senha']) == true)) {

  unset($_SESSION['login']);
  unset($_SESSION['senha']);
  header('Location: telalogin.php');
}
$logado = $_SESSION['login'];

// Despesas Pendentes
$sql_pendentes = "SELECT SUM(valor) AS total_pendentes FROM despesas WHERE pago = '0'";
$result_pendentes = $pdo->query($sql_pendentes);

$total_pendentes = 0;
if ($result_pendentes->num_rows > 0) {
  $row = $result_pendentes->fetch_assoc();
  $total_pendentes = $row['total_pendentes'] ?: 0;
}

// Despesas Recebidas
$sql_recebidas = "SELECT SUM(valor) AS total_recebidas FROM despesas WHERE pago = '1'";
$result_recebidas = $pdo->query($sql_recebidas);

$total_recebidas = 0;
if ($result_recebidas->num_rows > 0) {
  $row = $result_recebidas->fetch_assoc();
  $total_recebidas = $row['total_recebidas'] ?: 0;
}

// Total Geral
$total_geral = $total_pendentes + $total_recebidas;
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Family Financing</title>
  <link rel="shortcut icon" href="imagem/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="css/styleTelaReceita.css">
  <script src="js"></script>

</head>

<body>
  <div class="container">
    <!-- Navbar -->
    <nav class="navbar">
      <div class="navbar-left">
        <img src="imagem/logo_Family_Financing.png" alt="Ícone" class="navbar-icon">
        <span class="project-name">Family Financing</span>
      </div>
      <div class="navbar-right">
        <span class="user-name"> <?php echo "Ola, $logado"; ?> </span>
        <a href="telaHome.php"><button class="logout-btn">Voltar ao Home</button></a>
      </div>
    </nav>

    <!-- Conteúdo principal -->
    <main class="main-container">

      <header class="header">
        <h1>Despesas</h1>
        <button id="nova-despesa-btn" onclick="abrirModal()" class="logout-btn"> Nova despesa</a></button>
      </header>

      <!-- Resumo -->
      <section class="summary">
        <div class="card">
          <h2>Despesas pendentes</h2>
          <p>R$ <?php echo number_format($total_pendentes, 2, ',', '.'); ?></p>
        </div>
        <div class="card">
          <h2>Despesas recebidas</h2>
          <p>R$ <?php echo number_format($total_recebidas, 2, ',', '.'); ?></p>
        </div>
        <div class="card">
          <h2>Total</h2>
          <p>R$ <?php echo number_format($total_geral, 2, ',', '.'); ?></p>
        </div>
      </section>

      <!-- Tabela de despesas com navegação -->
      <section class="despesas">
        <div class="mes-navegacao">
          <button id="mes-anterior" class="nav-btn">◀</button>
          <h2 id="mes-ano">Janeiro 2022</h2>
          <button id="mes-proximo" class="nav-btn">▶</button>
        </div>
        <table>
          <thead>
            <tr>
              <th>Situação</th>
              <th>Data</th>
              <th>Categoria</th>
              <th>Descrição</th>
              <th>Valor</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php
            $consulta = "SELECT * FROM despesas";
            $resultado = $pdo->query($consulta);

            while ($linha = mysqli_fetch_assoc($resultado)) {

              $status_pago = $linha['pago']; // Exemplo
            
              // Renderizando o ícone
              $icone_status = $status_pago == '1'
                ? '<span style="color: green;">&#x2705;</span>' // Bolinha com verificado
                : '<span style="color: gray;">&#x26AA;</span>';  // Bolinha vazia
            

              echo "<tr>";
              echo "<td>" . $icone_status . "</td>";
              echo "<td>" . $linha["dataVenc"] . "</td>";
              echo "<td>" . $linha["categoria"] . "</td>";
              echo "<td>" . $linha["descricao"] . "</td>";
              echo "<td>" . $linha["valor"] . "</td>";
              echo "<td><a href='#' class='edit-btn' 
                        data-id='{$linha["id"]}' 
                        data-valor='{$linha["valor"]}' 
                        data-categoria='{$linha["categoria"]}' 
                        data-descricao='{$linha["descricao"]}' 
                        data-dataVenc='{$linha["dataVenc"]}' 
                        data-pago='{$linha["pago"]}'>
                        <img src='imagem/lapis1.jpg' alt='Alterar'></a> 
                        &nbsp;&nbsp;
                        <a href='deletDespesa.php?id=$linha[id]'><img src='imagem/excluir1.jpg' alt='Deletar'></a>
                    </td>";

              echo "</tr>";
            }
            ?>

          </tbody>
        </table>
      </section>
    </main>
  </div>

  <!-- Formulario de inserir despesas -->

  <div class="form-container">
    <div class="formulario">
      <form id="formNovaDespesa" action="inserirDespesa.php" method="POST">
        <header class="form-header">
          <h2>Nova Despesa</h2>
          <button type="button" class="close-btn" id="close-btn">&times;</button>

        </header>

        <!-- Valor -->
        <div class="form-group">
          <label for="valor">Valor</label>
          <div class="valor-input">
            <span class="currency">R$</span>
            <input type="number" name="valor" step="0.01" placeholder="0,00" required>
          </div>
        </div>

        <!-- Categoria -->
        <div class="form-group">
          <label for="categoria">Categoria</label>
          <input type="text" id="categoria" name="categoria" placeholder="" required>

        </div>

        <!-- Descrição -->
        <div class="form-group">
          <label for="Descrição">Descrição</label>
          <div class="valor-input">
            <input type="text" name="descricao" placeholder="" required>
          </div>
        </div>

        <div class="form-group">
          <div class="form-row">
            <div class="form-column">
              <label for="dataVenc"><b>Data de Registro</b></label>
              <input type="date" name="dataVenc" id="dataVenc" required>
            </div>

          </div>
        </div>

        <!-- Estado -->
        <div class="form-group">
          <label for="pago">Foi recebido?</label>
          <label class="toggle-switch">
            <input type="checkbox" name="pago">
            <span class="switch-slider"></span>
          </label>
        </div>

        <!-- Botões -->
        <div class="form-footer">
          <button type="submit" name="submit" class="submit-btn">Salvar</button>
          <button type="button" class="cancel-btn" id="cancel-btn"> Cancelar</button>
        </div>
      </form>
    </div>
  </div>

  <!-- Formulário de Atualização de Despesa -->
  <div class="form-container" id="update-form-container">
    <div class="formulario">
      <form id="formUpdateDespesa" action="updateDespesa.php" method="POST">
        <header class="form-header">
          <h2>Atualizar Despesa</h2>
          <button type="button" class="close-btn" id="close-update-btn">&times;</button>
        </header>

        <!-- Campo oculto para armazenar o ID da despesa -->
        <input type="hidden" name="id" id="update-id">

        <!-- Valor -->
        <div class="form-group">
          <label for="update-valor">Valor</label>
          <div class="valor-input">
            <span class="currency">R$</span>
            <input type="number" name="valor" id="update-valor" step="0.01" required>
          </div>
        </div>

        <!-- Categoria -->
        <div class="form-group">
          <label for="update-categoria">Categoria</label>
          <input type="text" name="categoria" id="update-categoria" required>
        </div>

        <!-- Descrição -->
        <div class="form-group">
          <label for="update-descricao">Descrição</label>
          <input type="text" name="descricao" id="update-descricao" required>
        </div>

        <!-- Data -->
        <div class="form-group">
          <label for="update-dataVenc">Data de Registro</label>
          <input type="date" name="dataVenc" id="update-dataVenc" required>
        </div>

        <!-- Pago -->
        <div class="form-group">
          <label for="update-pago">Foi pago?</label>
          <label class="toggle-switch">
            <input type="checkbox" name="pago" id="update-pago">
            <span class="switch-slider"></span>
          </label>
        </div>

        <!-- Botões -->
        <div class="form-footer">
          <button type="submit" class="submit-btn" id="submit" name="submit">Salvar</button>
          <button type="button" class="cancel-btn" id="cancel-update-btn">Cancelar</button>
        </div>
      </form>
    </div>
  </div>


  <script>
    // Adicione este código no início do script para ocultar o formulário ao carregar a página
    document.addEventListener("DOMContentLoaded", function () {
      document.querySelector(".form-container").style.display = "none";
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
        const id = this.getAttribute("data-id");
        const valor = this.getAttribute("data-valor");
        const categoria = this.getAttribute("data-categoria");
        const descricao = this.getAttribute("data-descricao");
        const dataVenc = this.getAttribute("data-dataVenc");
        const pago = this.getAttribute("data-pago") === "1"; // Converte string para booleano

        // Preenchendo os campos do formulário
        document.getElementById("update-id").value = id;
        document.getElementById("update-valor").value = valor;
        document.getElementById("update-categoria").value = categoria;
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

  </script>
</body>

</html>