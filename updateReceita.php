<?php
session_start();
include "Classes\Receita.class.php";
$rec = $receita = new Receita();

if (!$rec) {
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
            $valor = $_POST['valor'];
            $categoria = $_POST['categoria'];
            $tipoReceita = $_POST['tipoReceita'];
            $data_registro = $_POST['data_registro'];
            $numero_parcelas = $_POST['numParcelas'] ?: 1;
            $pago = isset($_POST['pago']) ? 1 : 0;

            $receita->alterarReceita($id, $categoria, $tipoReceita, $valor, $data_registro, $numParcelas, $pago);

        } else {
            echo "Erro ao conectar ao banco de dados";

        }
    }
}
header('Location: telaReceita.php');
?>