<?php
session_start();

include 'Classes/Receita.class.php';
include 'Classes/Despesa.class.php';
include 'Classes/Usuario.class.php';


if ((!isset($_SESSION['email'])) and (!isset($_SESSION['senha']))) {
    unset($_SESSION['email']);
    unset($_SESSION['senha']);
    header('Location: telalogin&cadastro.php');
}

$logado = $_SESSION['login'];
$email = $_SESSION['email'];
$id = $_SESSION['id'];
$nivel_acesso = $_SESSION['nivel_acesso'];
$grupo_familiar = $_SESSION['grupo_familiar'];

$con = $receita = new Receita();
if (!$con) {
    echo "<script>
            confirm('Erro ao conectar ao banco de dados')
        </script>";
} else {
    $total_receitas = $receita->somaReceitas($id);
}

$con = $despesa = new Despesa();
if (!$con) {
    echo "<script>
            confirm('Erro ao conectar ao banco de dados')
        </script>";
} else {
    $total_despesas = $despesa->despesasPendentes($id);
}

// Total Geral
$total_saldo = $total_receitas - $total_despesas;

$usuario = new Usuario();
$dataUsuario = $usuario->usuario($id);

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Financing</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="shortcut icon" href="imagem/favicon.ico" type="image/x-icon">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

    <!-- Sidebar -->
    <aside class="sidebar">
        <ul>
            <li><span class="icon">🏠</span><span class="text"><a href="telaHome.php"> Home </a></span></li>
            <li><span class="icon">💸</span><span class="text"><a href="telaDespesa.php">Despesas</a></span></li>
            <li><span class="icon">💰</span><span class="text"><a href="telaReceita.php">Receitas</a></span></li>
            <li><span class="icon">❌</span><span class="text"><a href="sair.php">Sair</a></span></li>
        </ul>
    </aside>

    <!-- Container principal que será empurrado pelo sidebar -->
    <div class="main-container">
    <header>

        <div class="container">
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
                            <?php }?> 
                        </div>
                    </div>

                    <div class="group-member">
                        <span>Maria Silva - 20%</span>
                        <div class="icons">
                            <?php if ($nivel_acesso == 'admin') { ?>
                            <i class="fas fa-pencil-alt edit-icon" data-tooltip="Editar"></i>
                            <i class="fas fa-trash delete-icon" data-tooltip="Excluir"></i>
                            <?php }?> 
                        </div>
                    </div>
                    <div class="group-member">
                        <span>Carlos Souza - 15%</span>
                        <div class="icons">
                            <?php if ($nivel_acesso == 'admin') { ?>
                            <i class="fas fa-pencil-alt edit-icon" data-tooltip="Editar"></i>
                            <i class="fas fa-trash delete-icon" data-tooltip="Excluir"></i>
                            <?php }?>  
                        </div>
                    </div>

                    <div class="buttons">
                        <?php if ($nivel_acesso == 'admin') { ?>
                             <button class="btn invite">Convidar pessoas</button>
                            <?php }?>                                                     
                        <button class="btn leave">Sair do grupo</button>
                        <button class="btn delete">Excluir Perfil</button>
                    </div>
                </div>
            </div>

            <!-- Seção Principal -->
            <section class="summary">
                <!-- Painel do Saldo -->
                <div class="card" id="saldo">
                    <h2>Receitas</a></h2>
                    <p id="receita-valor">R$ <?php echo number_format($total_receitas, 2, ',', '.'); ?></p>
                </div>

                <!-- Painel de Despesas -->
                <div class="card" id="despesas">
                    <h2>Despesas</a></h2>
                    <p id="despesa-valor">R$ <?php echo number_format($total_despesas, 2, ',', '.'); ?></p>
                </div>

                <!-- Painel de Receitas -->
                <div class="card" id="receitas">
                    <h2>Saldo Atual</h2>
                    <p id="saldo-valor">R$ <?php echo number_format($total_saldo, 2, ',', '.'); ?></p>
                </div>
            </section>

        </div>
    </div>

    <script src="js/script.js"></script>
    <script src="js/scriptMenu.js"></script>

    

</body>

</html>