<?php
session_start();
require 'Classes\Receita.class.php';
$con = $receita = new Receita();

if (!$con) {
  echo "Erro ao conectar ao banco de dados";
  exit;
} else {
  if ((!isset($_SESSION['login']) == true) and (!isset($_SESSION['senha']) == true)) {
    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    header('Location: telalogin.php');
  }
  $logado = $_SESSION['login'];
  $id = $_SESSION['id'];
  $grupo_familiar = $_SESSION['grupo_familiar'];

  // Pegar o mês e ano atuais para inicializar os valores
  $mes_atual = date('m');
  $ano_atual = date('Y');

  // Receitas Pendentes do mês atual
  $total_pendente = $receita->receitasPendentes($id, $mes_atual, $ano_atual);

  // Receitas Recebidas do mês atual
  $total_recebidas = $receita->receitasRecebidas($id, $mes_atual, $ano_atual);

  // Total Geral
  $total_geral = $total_pendente + $total_recebidas;
}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Family Financing</title>
  <link rel="stylesheet" href="css/styleTelaReceita.css">
  <link rel="shortcut icon" href="imagem/favicon.ico" type="image/x-icon">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>
  <div class="container">
    <!-- Navbar -->
    <nav class="navbar">
      <div class="navbar-left">
        <img src="imagem/logo_Fam_Finan.png" alt="Ícone" class="navbar-icon">
        <span class="project-name">Family Financing</span>
      </div>
      <div class="navbar-right">
        <span class="user-name"> <?php echo "Ola, $logado "; ?> 
        <br> 
        <?php echo "Você pertence ao grupo: $grupo_familiar "; ?> </span>
        <button class="logout-btn"><a href="telaHome.php">Voltar ao Home</a></button>
      </div>
    </nav>

    <!-- Conteúdo principal -->
    <main class="main-container">

      <header class="header">
        <h1>Receitas</h1>
        <button id="nova-receita-btn" onclick="abrirModal()" class="logout-btn"> Nova Receita</a></button>
      </header>

      <!-- Resumo -->
      <section class="summary">
        <div class="card">
          <h2>Receitas pendentes</h2>
          <p>R$ <?php echo number_format($total_pendente, 2, ',', '.'); ?></p>
        </div>
        <div class="card">
          <h2>Receitas recebidas</h2>
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
              <th>Valor</th>
              <th>Ações</th>
            </tr>
          </thead>
          <tbody>
            <?php

            $receitas = $receita->receitas($id);
            foreach ($receitas as $key => $linha) {
              # code...
            
              $status_pago = $linha['pago']; // Exemplo
              $icone_status = $status_pago == '1' // Renderizando o ícone
                ? '<span style="color: green;">&#x2705;</span>' // Bolinha com verificado
                : '<span style="color: gray;">&#x26AA;</span>';  // Bolinha vazia
            
              // Adiciona o ícone para o tipo de receita
              $tipo_icone = $linha['tipoReceita'] == 'individual'
                ? '<i class="far fa-user icon-modify"></i>' // Ícone para individual
                : '<i class="fas fa-users icon-modify"></i>'; // Ícone para grupo  

              // Pega o ano e mês da receita
              $data = new DateTime($linha["data_registro"]);
              $ano = $data->format('Y');
              $mes = $data->format('m');

              echo "<tr data-ano='{$ano}' data-mes='{$mes}'>";
              echo "<td>" . $icone_status . "</td>";
              echo "<td>" . $linha["data_registro"] . "</td>";
              echo "<td>" . $tipo_icone ."  ". $linha['categoria'] . "</td>";
              echo "<td>" . $linha["valor"] . "</td>";
              echo "<td> <a href='#' class='edit-btn' 
                          data-id='{$linha["id"]}'
                          data-id_usuario='{$linha["id_usuario"]}' 
                          data-valor='{$linha["valor"]}' 
                          data-categoria='{$linha["categoria"]}' 
                          data-data_registro='{$linha["data_registro"]}' 
                          data-numParcelas='{$linha["numParcelas"]}' 
                          data-pago='{$linha["pago"]}'>
                          <img src='imagem/lapis1.jpg' alt='Alterar'></a> 
                          &nbsp;&nbsp;
                          <a href='deletReceita.php?id=$linha[id]'><img src='imagem/excluir1.jpg' alt='Deletar'></a>
                    </td>";
              ;

              echo "</tr>";

            }
            ?>

          </tbody>
        </table>
      </section>
    </main>
  </div>

  <!-- Formulário de Receita -->
  <div class="form-container" id="form-container">
    <div class="formulario">
      <form id="form-receita" action="inserirReceita.php" method="POST">
        <header class="form-header">
          <h2>Receita</h2>
          <button type="button" class="close-btn" id="close-btn">&times;</button>
        </header>

        <!-- Definição do tipo de receita -->
        <div class="radio-group">
          <label class="radio-option">
            <input type="radio" name="tipoReceita" value="individual" checked />
            Individual
          </label>
          <label class="radio-option">
            <input type="radio" name="tipoReceita" value="grupo" />
            Grupo
          </label>
        </div>

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
          <label for="Categoria">Categoria</label>
          <div class="valor-input">
            <input type="text" name="categoria" placeholder="" required>
          </div>
        </div>

        <div class="form-group">
          <div class="form-row">
            <div class="form-column">
              <label for="data_registro"><b>Data de Registro</b></label>
              <input type="date" name="data_registro" id="data_registro" required>
            </div>
            <div class="form-column">
              <label for="numParcelas">Número de Parcelas</label>
              <input type="number" name="numParcelas" placeholder="Nº de parcelas">
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
          <button type="button" class="cancel-btn" id="cancel-btn"> Cancelar</a></button>
        </div>
      </form>
    </div>
  </div>

  <!-- Formulário de Atualização de Receita -->
  <div class="form-container" id="update-form-container">
    <div class="formulario">
      <form id="formUpdateReceita" action="updateReceita.php" method="POST">
        <header class="form-header">
          <h2>Atualizar Receita</h2>
          <button type="button" class="close-btn" id="close-update-btn">&times;</button>
        </header>

        <!-- Campo oculto para armazenar o ID da receita -->
        <input type="hidden" name="id_usuario" id="update-id_usuario">
        <input type="hidden" name="id" id="update-id">

        <!-- Definição do tipo de receita -->
        <div class="radio-group">
          <label class="radio-option">
            <input type="radio" name="tipoReceita" value="individual" checked />Individual</label>
          <label class="radio-option">
            <input type="radio" name="tipoReceita" value="grupo" /> Grupo </label>
        </div>

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

        <!-- Data -->
        <div class="form-group">
          <div class="form-row">
            <div class="form-column">
              <label for="update-data_registro">Data de Registro</label>
              <input type="date" name="data_registro" id="update-data_registro" required>
            </div>
            <div class="form-column">
              <label for="update-numParcelas">Número de Parcelas</label>
              <input type="number" name="numParcelas" id="update-numParcelas">
            </div>
          </div>
        </div>

        <!-- Estado -->
        <div class="form-group">
          <label for="update-pago">Foi recebido?</label>
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

  <script src="js/telaReceita.js"></script>

</body>

</html>