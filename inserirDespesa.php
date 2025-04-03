<?php

include("config.php");

// Obtém os dados do formulário
$categoria = $_POST['categoria'];
$descricao = $_POST['descricao'];
$valor = $_POST['valor'];
$dataVenc = $_POST['dataVenc'];
$pago = isset($_POST['pago']) ? 1 : 0;
//$id_usuario = $_SESSION['id_usuario'];

// Prepara o comando SQL para inserção
 $inserir = $pdo->prepare("insert into despesas (categoria, descricao, valor, dataVenc, pago) 
        values ('$categoria', '$descricao', '$valor', '$dataVenc', '$pago')");

$inserir->execute();

header("location:telaDespesa.php");

?>
