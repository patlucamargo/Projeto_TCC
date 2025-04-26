<?php
session_start();

if (!empty($_GET['id'])) {

    include "Classes\Receita.class.php";
    $rec = $receita = new Receita();

    $id = $_GET['id'];

    $receita->deletreceitas($id);

}

header('Location: telaReceita.php');


?>