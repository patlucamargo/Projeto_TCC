<?php
session_start();

if (!empty($_GET['id'])) {
    
    include "Classes\Despesa.class.php";
    $desc = $despesa = new Despesa();

    $id = $_GET['id'];

    $despesa->deletdespesas($id);
    }      

header('Location: telaDespesa.php');


?>