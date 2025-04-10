<?php
session_start();
include'Usuario.class.php';

if ( (!isset($_SESSION['email']) ) and ( !isset($_SESSION['senha'] ) ) ) {

    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    header('Location: telalogin.php');
}

$logado = $_SESSION['email'];
$con = $usuario = new Usuario();
if(!con){
    echo "<script>
    confirm('Erro ao conectar ao banco de dados')
</script>";
}else{
    $ckDespesas = $usuario->somaDespesasReceitas($email, "D");
    $total_despesas = $shkUs;
    $ckReceitas = $usuario->somaDespesasReceitas($email, "R");
    $total_receitas = $shkUs;

    // Total Geral
    $total_saldo = $total_receitas - $total_despesas;
} else {
    // Caso não encontre o usuário
    $total_despesas = 0;
    $total_receitas = 0;
    $total_saldo = 0;
}

?>

<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Financing</title>
    <link rel="stylesheet" href="css/style.css">
    <link rel="shortcut icon" href="imagem/favicon.ico" type="image/x-icon">
</head>

<body>
    <header>

        <div class="container">
            <!-- Navbar -->
            <nav class="navbar">
                <div class="navbar-left">
                    <img src="imagem/logo_Family_Financing.png" alt="Ícone" class="navbar-icon">
                    <span class="project-name">Family Financing</span>
                </div>
                <div class="navbar-right">
                    <span class="user-name"> <?php echo "Ola, $logado"; ?></span>
                    <button class="logout-btn"><a href="sair.php">Sair</a></button>
                </div>
            </nav>
        </div>

    </header>

    <!-- Seção Principal -->
    <section class="summary">
        <!-- Painel do Saldo -->
        <div class="card" id="saldo">
            <h2><a href="telaReceita.php">Receitas</a></h2>
            <p id="receita-valor">R$ <?php echo number_format($total_receitas, 2, ',', '.'); ?></p>
        </div>

        <!-- Painel de Despesas -->
        <div class="card" id="despesas">
            <h2><a href="telaDespesa.php">Despesas</a></h2>
            <p id="despesa-valor">R$ <?php echo number_format($total_despesas, 2, ',', '.'); ?></p>
        </div>

        <!-- Painel de Receitas -->
        <div class="card" id="receitas">
            <h2>Saldo Atual</h2>
            <p id="saldo-valor">R$ <?php echo number_format($total_saldo, 2, ',', '.'); ?></p>
        </div>
        </div>
    </section>

</body>

</html>