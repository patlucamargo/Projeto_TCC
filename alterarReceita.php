<?php

if (!empty($_GET['id'])) {

include("config.php");

$id = $_GET['id'];

$sqlSelect = "SELECT * FROM receitas WHERE id=$id";

$result = $pdo->query($sqlSelect);

if($result->num_rows > 0){
    while($user_data = mysqli_fetch_assoc($result)){

$id = $user_data['id'];
$valor = $user_data['valor'];
$categoria = $user_data['categoria'];
$dt = $user_data['data_registro']; // Usa a data atual se não for informada
$numero_parcelas = $user_data['numParcelas'] ?: 1; // Define 1 parcela como padrão se não for informada
$pago = $user_data['pago'];
    }

}else{
    header('Location: telaReceita.php');
    }
}

?>


<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Family Financing</title>
    <link rel="stylesheet" href="css/styleFormularioReceita.css">
    <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
</head>

<body>

    <!-- Formulário de Cadasrto Receita -->
    <div class="form-container" id="form-container">
        <form id="form-receita" action="updateReceita.php" method="POST">
            <header class="form-header">
                <h2>Alterar Receita</h2>
                <button type="button" class="close-btn" id="close-btn">&times;</button>
            </header>

            <!-- Valor -->
            <div class="form-group">
                <label for="valor">Valor</label>
                <div class="valor-input">
                    <span class="currency">R$</span>
                    <input type="number" name="valor" step="0.01" placeholder="0,00" value="<?php echo $valor ?>" required>
                </div>
            </div>

            <!-- Categoria -->
            <div class="form-group">
                <label for="Categoria">Categoria</label>
                <div class="valor-input">
                    <input type="text"  name="categoria" placeholder="" value="<?php echo $categoria ?>" required>
                </div>
            </div>

            <div class="form-group">
                <div class="form-row">
                    <div class="form-column">
                    <label for="data_registro"><b>Data de Registro</b></label>
                    <input type="date" name="data_registro" id="data_registro" value="<?php echo $dt ?>" required>
                    </div>

                    <div class="form-column">
                        <label for="numParcelas">Número de Parcelas</label>
                        <input type="number" name="numParcelas" placeholder="Nº de parcelas" value="<?php echo $numero_parcelas ?>" >
                    </div>
                </div>
            </div>

            <!-- Estado -->
            <div class="form-group">
                <label for="pago">Foi recebido?</label>
                <label class="toggle-switch">
                    <input type="checkbox" name="pago" <?php echo ($pago == '1') ? 'checked' :'' ?> >
                    <span class="switch-slider"></span>
                </label>
            </div>
            <input type="hidden" name="id" value="<?php echo $id ?>" >

            
            <!-- Botões -->
            <div class="form-footer">
                <button type="submit" name="submit" class="submit-btn">Alterar</button>
                <button type="button" class="cancel-btn" id="cancel-btn"> <a
                        href="telaReceita.php">Voltar</a></button>
            </div>
        </form>
    </div>

   <script src="js/javascriptFormularioReceita.js"></script>
</body>

</html>