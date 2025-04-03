<?php

    include_once('config.php');

    if(isset($_POST['submit'])){
    
    $id = $_POST['id'];
    $categoria = $_POST['categoria'];
    $descricao = $_POST['descricao'];
    $valor = $_POST['valor'];
    $dataVenc = $_POST['dataVenc']; 
    $pago = isset($_POST['pago']) ? 1 : 0;

    $sqlUpdate = "UPDATE despesas SET categoria='$categoria', descricao='$descricao', valor='$valor',  dataVenc='$dataVenc',  pago='$pago'
    WHERE id='$id'";

    $result = $pdo->query($sqlUpdate);
    print_r($result);

    }

    header ('Location: telaDespesa.php');
?>