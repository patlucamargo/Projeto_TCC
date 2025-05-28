<?php
session_start();
include 'Classes\Despesa.class.php';
include 'Classes\Usuario.class.php';

$con = $despesa = new Despesa();

if (!$con) {
  echo "Erro ao conectar ao banco de dados";
  exit;
} else {
  if ((!isset($_SESSION['login']) == true) and (!isset($_SESSION['senha']) == true)) {

    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    header('Location: telalogin&cadastro.php');
  }

  $logado = $_SESSION['login'];
  $id = $_SESSION['id'];
  $grupo_familiar = $_SESSION['grupo_familiar'];
  $nivel_acesso = $_SESSION['nivel_acesso'];

  // Pegar o mês e ano atuais para inicializar os valores
  $mes_atual = date('m');
  $ano_atual = date('Y');

  // Despesas Pendentes
  $total_pendentes = $despesa->despesasPendentesMes($id, $mes_atual, $ano_atual);

  // Despesas Recebidas
  $total_recebidas = $despesa->despesasRecebidasMes($id, $mes_atual, $ano_atual);

  // Total Geral
  $total_geral = $total_pendentes + $total_recebidas;

  $usuario = new Usuario();
  $dataUsuario = $usuario->usuario($id);

}
?>

<!DOCTYPE html>
<html lang="pt-BR">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Family Financing</title>
  <link rel="shortcut icon" href="imagem/favicon.ico" type="image/x-icon">

  <link rel="stylesheet" href="css/styleTelaReceita.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

</head>

<body>

  <!-- Navbar -->
  <nav class="navbar">
    <div class="navbar-left">
      <img src="imagem/logo_Fam_Finan.png" alt="Ícone" class="navbar-icon">
      <span class="project-name">Family Financing</span>
    </div>

    <div class="profile" onclick="toggleProfile()">
      <span class="user-name"><?php echo "Ola, $logado"; ?>
        <br>
        <?php echo "Você é $nivel_acesso do grupo: $grupo_familiar"; ?>
      </span>
      <img src="imagem/perfil.png" alt="Perfil" class="profile-pic" />
    </div>
  </nav>

  <aside class="sidebar">
    <ul>
      <li><span class="icon">🏠</span><span class="text"><a href="telaHome.php"> Home </a></span></li>
      <li><span class="icon">💸</span><span class="text"><a href="telaDespesa.php">Despesas</a></span></li>
      <li><span class="icon">💰</span><span class="text"><a href="telaReceita.php">Receitas</a></span></li>
      <li><span class="icon">❌</span><span class="text"><a href="sair.php">Sair</a></span></li>
    </ul>
  </aside>


  <!-- Profile Panel -->
  <div class="profile-panel" id="profilePanel">
    <div class="profile-header">
      <h2>Meu Perfil</h2>
      <span class="close-btn" onclick="toggleProfile()">&times;</span>
    </div>

    <div class="profile-content">
      <div class="profile-pic-wrapper">
        <img src="imagem/perfil.png" alt="Foto de Perfil" class="profile-pic-large" />
        <i class="fas fa-pencil-alt edit-icon" data-tooltip="Editar"></i>
      </div>

      <div class="info-item">
        <label>Nome:</label>
        <div class="input-with-icon">
          <input type="text" value="<?php echo $dataUsuario['nome_completo'] ?>" readonly />
        </div>
      </div>

      <div class="info-item">
        <label>E-mail:</label>
        <div class="input-with-icon">
          <input type="text" value="<?php echo $dataUsuario['email'] ?>" readonly />
        </div>
      </div>

      <div class="info-item">
        <label>Como gostaria de ser chamado:</label>
        <div class="input-with-icon">
          <input type="text" value="<?php echo $dataUsuario['login'] ?>" readonly />
        </div>
      </div>

      <div class="info-item">
        <label>Grupo Familiar:</label>
        <div class="input-with-icon">
          <input type="text" value="<?php echo $dataUsuario['grupo_familiar'] ?>" readonly />
        </div>
      </div>

      <div class="info-item">
        <label>Contribuição (%):</label>
        <div class="input-with-icon">
          <input type="text" value="35%" readonly />
        </div>
      </div>

      <h3>Integrantes do Grupo Camargo</h3>
      <div class="group-member">
        <span>João Pereira - 30%</span>
        <div class="icons">
          <?php if ($nivel_acesso == 'admin') { ?>
            <i class="fas fa-pencil-alt edit-icon" data-tooltip="Editar"></i>
            <i class="fas fa-trash delete-icon" data-tooltip="Excluir"></i>
          <?php } ?>
        </div>
      </div>

      <div class="group-member">
        <span>Maria Silva - 20%</span>
        <div class="icons">
          <?php if ($nivel_acesso == 'admin') { ?>
            <i class="fas fa-pencil-alt edit-icon" data-tooltip="Editar"></i>
            <i class="fas fa-trash delete-icon" data-tooltip="Excluir"></i>
          <?php } ?>
        </div>
      </div>
      <div class="group-member">
        <span>Carlos Souza - 15%</span>
        <div class="icons">
          <?php if ($nivel_acesso == 'admin') { ?>
            <i class="fas fa-pencil-alt edit-icon" data-tooltip="Editar"></i>
            <i class="fas fa-trash delete-icon" data-tooltip="Excluir"></i>
          <?php } ?>
        </div>
      </div>

      <div class="buttons">
        <?php if ($nivel_acesso == 'admin') { ?>
          <button class="btn invite">Convidar pessoas</button>
        <?php } ?>
        <button class="btn leave">Sair do grupo</button>
        <button class="btn delete">Excluir Perfil</button>
      </div>
    </div>
  </div>
  <!-- Conteúdo principal -->
  <div class="main-container">
    <div class="container">
      <header class="header">
        <h1>Despesas</h1>
        <button id="nova-receita-btn" onclick="abrirModal()" class="logout-btn"> Nova despesa</a></button>
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

            $despesas = $despesa->despesas($id);
            foreach ($despesas as $key => $linha) {
              # code...
            
              $status_pago = $linha['pago']; // Exemplo
              $icone_status = $status_pago == '1' // Renderizando o ícone
                ? '<span style="color: green;">&#x2705;</span>' // Bolinha com verificado
                : '<span style="color: gray;">&#x26AA;</span>';  // Bolinha vazia
            
              // Adiciona o ícone para o tipo de receita
              $tipo_icone = $linha['tipoDespesa'] == 'individual'
                ? '<i class="far fa-user icon-modify"></i>' // Ícone para individual
                : '<i class="fas fa-users icon-modify"></i>'; // Ícone para grupo  
            
              // Pega o ano e mês da Despesa
              $data = new DateTime($linha["dataVenc"]);
              $ano = $data->format('Y');
              $mes = $data->format('m');

              echo "<tr data-ano='{$ano}' data-mes='{$mes}'>";
              echo "<td>" . $icone_status . "</td>";
              echo "<td>" . $linha["dataVenc"] . "</td>";
              echo "<td>" . $tipo_icone . "  " . $linha["categoria"] . "</td>";
              echo "<td>" . $linha["descricao"] . "</td>";
              echo "<td>" . $linha["valor"] . "</td>";
              echo "<td><a href='#' class='edit-btn' 
                        data-id='{$linha["id"]}' 
                        data-id_usuario='{$linha["id_usuario"]}'
                        data-valor='{$linha["valor"]}' 
                        data-categoria='{$linha["categoria"]}' 
                        data-tipoDespesa='{$linha["tipoDespesa"]}'
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
  </div>

  <!-- Formulario de inserir despesas -->
  <div class="form-container" id="form-container">
    <div class="formulario">
      <form id="formNovaDespesa" action="inserirDespesa.php" method="POST">
        <header class="form-header">
          <h2>Nova Despesa</h2>
          <button type="button" class="close-btn" id="close-btn">&times;</button>
        </header>

        <input type="hidden" name="id_usuario" value="<?php echo $_SESSION['id']; ?>">

        <!-- Definição do tipo de Despesa -->
        <?php
        if ($nivel_acesso == 'admin') {
          echo '<div class="radio-group">
          <label class="radio-option">
            <input type="radio" name="tipoDespesa" value="individual" checked />
            Individual
          </label>
          <label class="radio-option">
            <input type="radio" name="tipoDespesa" value="grupo" />
            Grupo
          </label>
        </div>';
        }

        ?>

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
          <div class="valor-input">
            <input type="text" id="categoria" name="categoria" placeholder="" required>
          </div>
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
          <button type="button" class="cancel-btn" id="cancel-btn">Cancelar</button>
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
        <input type="hidden" name="id_usuario" id="update-id_usuario">
        <input type="hidden" name="id" id="update-id">

        <!-- Definição do tipo de receita -->
        <div class="radio-group">
          <label class="radio-option">
            <input type="radio" name="tipoDespesa" value="individual" id="update-tipoDespesa"
              checked />Individual</label>
          <label class="radio-option">
            <input type="radio" name="tipoDespesa" value="grupo" id="update-tipoDespesa" /> Grupo </label>
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

        <!-- Descrição -->
        <div class="form-group">
          <label for="update-descricao">Descrição</label>
          <input type="text" name="descricao" id="update-descricao" required>
        </div>

        <!-- Data -->
        <div class="form-group">
          <div class="form-row">
            <div class="form-column">
              <label for="update-dataVenc">Data de Registro</label>
              <input type="date" name="dataVenc" id="update-dataVenc" required>
            </div>
          </div>
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


  <script src="js/telaDespesa.js"></script>
  <script src="js/scriptMenu.js"></script>
</body>

</html>