<?php

session_start();
include("config.php");

//if (!empty($_GET['id'])) {
    //$logado = $_SESSION['id_usuario'];
    $id = $_GET['id'];

    $sqlSelect = "SELECT * FROM despesas WHERE id=$id";

    $result = $pdo->query($sqlSelect);
//teste
    if ($result->num_rows > 0) {
        while ($user_data = mysqli_fetch_assoc($result)) {

            $id = $user_data['id'];
            $categoria = $user_data['categoria'];
            $descricao = $user_data['descricao'];
            $valor = $user_data['valor'];
            $dataVenc = $user_data['dataVenc'];
            $pago = $user_data['pago'];

        }

    } else {
        header('Location: telaDespesa.php');
    }
//}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Financing</title>
    <link rel="stylesheet" href="css/styleFormularioReceita.css">
    <link rel="shortcut icon" href="imagem/favicon.ico" type="image/x-icon">
</head>

<body>

    <!-- Formulário de Cadasrto Receita -->
    <div class="form-container" id="form-container">
        <form id="form-receita" action="updateDespesa.php" method="POST">
            <header class="form-header">
                <h2>Alterar Despesa</h2>
                <button type="button" class="close-btn" id="close-btn">&times;</button>
            </header>

            <!-- Valor -->
            <div class="form-group">
                <label for="valor">Valor</label>
                <div class="valor-input">
                    <span class="currency">R$</span>
                    <input type="number" name="valor" step="0.01" placeholder="0,00" value="<?php echo $valor ?>"
                        required>
                </div>
            </div>

            <!-- Categoria -->
            <div class="form-group">
                <label for="Categoria">Categoria</label>
                <div class="valor-input">
                    <input type="text" name="categoria" placeholder="" value="<?php echo $categoria ?>" required>
                </div>
            </div>

            <div class="form-group">
                <div class="form-row">
                    <div class="form-column">
                        <label for="dataVenc"><b>Data de Registro</b></label>
                        <input type="date" name="dataVenc" id="dataVenc" value="<?php echo $dataVenc ?>" required>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <label for="Descrição">Descrição</label>
                <div class="valor-input">
                    <input type="text" name="descricao" placeholder="" value="<?php echo $descricao ?>" required>
                </div>
            </div>


            <!-- Estado -->
            <div class="form-group">
                <label for="pago">Foi recebido?</label>
                <label class="toggle-switch">
                    <input type="checkbox" name="pago" <?php echo ($pago == '1') ? 'checked' : '' ?>>
                    <span class="switch-slider"></span>
                </label>
            </div>


            <input type="hidden" name="id" value="<?php echo $id ?>">

            <!-- Botões -->
            <div class="form-footer">
                <button type="submit" name="submit" class="submit-btn">Alterar</button>
                <button type="button" class="cancel-btn" id="cancel-btn"> <a href="telaDespesa.php">Voltar</a></button>
            </div>
        </form>
    </div>

    <script src="js/javascriptFormularioReceita.js"></script>
</body>

</html>