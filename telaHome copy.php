<?php
session_start();
include("config.php");

if ((!isset($_SESSION['login']) == true) and (!isset($_SESSION['senha']) == true)) {

    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    header('Location: telalogin.php');
}
$logado = $_SESSION['login'];

$sql_user = "SELECT id FROM usuario WHERE login = ?";
$stmt_user = $pdo->prepare($sql_user);
$stmt_user->bind_param("s", $logado);
$stmt_user->execute();
$result_user = $stmt_user->get_result();

if ($result_user->num_rows > 0) {
    $user = $result_user->fetch_assoc();
    $user_id = $user['id'];
//teste
    // Despesas
    $sql_despesas = "SELECT SUM(valor) AS total_despesas FROM despesas WHERE id_usuario = ?";
    $stmt_despesas = $pdo->prepare($sql_despesas);
    $stmt_despesas->bind_param("i", $user_id);
    $stmt_despesas->execute();
    $result_despesas = $stmt_despesas->get_result();

    $total_despesas = 0;
    if ($result_despesas->num_rows > 0) {
        $row = $result_despesas->fetch_assoc();
        $total_despesas = $row['total_despesas'] ?: 0;
    }

    // Receitas
    $sql_receitas = "SELECT SUM(valor) AS total_receitas FROM receitas WHERE id_usuario = ?";
    $stmt_receitas = $pdo->prepare($sql_receitas);
    $stmt_receitas->bind_param("i", $user_id);
    $stmt_receitas->execute();
    $result_receitas = $stmt_receitas->get_result();

    $total_receitas = 0;
    if ($result_receitas->num_rows > 0) {
        $row = $result_receitas->fetch_assoc();
        $total_receitas = $row['total_receitas'] ?: 0;
    }

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