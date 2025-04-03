<?php

    include_once('config.php');

    if(isset($_POST['submit'])){
    
    $id = $_POST['id'];
    $valor = $_POST['valor'];
    $categoria = $_POST['categoria'];
    $dt = $_POST['data_registro']; 
    $numero_parcelas = $_POST['numParcelas'] ?: 1; 
    $pago = isset($_POST['pago']) ? 1 : 0;

    $sqlUpdate = "UPDATE receitas SET valor='$valor', categoria='$categoria', data_registro='$dt', numParcelas='$numero_parcelas', pago='$pago'
    WHERE id='$id'";

    $result = $pdo->query($sqlUpdate);
    print_r($result);



    }

    header ('Location: telaReceita.php');
?>