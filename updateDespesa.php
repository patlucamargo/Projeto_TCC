<?php
session_start();
include "Classes\Despesa.class.php";

$desp = $despesa = new Despesa();

if (!$desp) {
    echo "Erro ao conectar ao banco de dados";
    exit;
} else {
    if ((!isset($_SESSION['login'])) && (!isset($_SESSION['senha']))) {
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
        header('Location: telalogin&cadastro.php');
    } else {

        if (isset($_POST['submit'])) {

            $id = $_POST['id'];
            $categoria = $_POST['categoria'];
            $descricao = $_POST['descricao'];
            $tipoDespesa = $_POST['tipoDespesa'];
            $valor = $_POST['valor'];
            $dataVenc = $_POST['dataVenc'];
            $pago = isset($_POST['pago']) ? 1 : 0;

            $despesa->alterarDespesa($id, $categoria, $tipoDespesa, 
            $descricao,$valor, $dataVenc, $pago);

            
        } else {
            echo "Erro ao conectar ao banco de dados";

        }

    }
}

header('Location: telaDespesa.php');
?>