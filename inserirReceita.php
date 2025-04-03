<?php

include("config.php");

// Obtém os dados do formulário
$valor = $_POST['valor'];
$categoria = $_POST['categoria'];
$dt = $_POST['data_registro']; // Usa a data atual se não for informada
$numero_parcelas = $_POST['numParcelas'] ?: 1; // Define 1 parcela como padrão se não for informada
$pago = isset($_POST['pago']) ? 1 : 0;

// Prepara o comando SQL para inserção
 $inserir = $pdo->prepare("insert into receitas (valor, categoria, data_registro, numParcelas, pago) 
        values ('$valor', '$categoria', '$dt', '$numero_parcelas', '$pago')");

$inserir->execute();

header("location:telaReceita.php");

?>
