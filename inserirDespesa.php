<?php
session_start();
require "Classes\Despesa.class.php";

$desp = $despesa = new Despesa();

if (!$desp) {
        echo "Erro ao conectar com o banco! Tente mais tarde";
        exit;
} else {

        if ((!isset($_SESSION['login'])) && (!isset($_SESSION['senha']))) {
                unset($_SESSION['login']);
                unset($_SESSION['senha']);
                header('Location: telalogin&cadastro.php');

        } else {
                if (isset($_POST['submit'])) {
                        // Obtém os dados do formulário
                        $categoria = $_POST['categoria'];
                        $descricao = $_POST['descricao'];
                        $tipoDespesa = $_POST['tipoDespesa'];
                        $valor = $_POST['valor'];
                        $dataVenc = $_POST['dataVenc']; // Usa a data atual se não for informada
                        $pago = isset($_POST['pago']) ? 1 : 0;
                        $id = $_SESSION['id'];
                                                
                        // Prepara o comando SQL para inserção
                        $despesa->inserirDespesa($id, $categoria, $descricao, $tipoDespesa, $valor, $dataVenc, $pago);
                } else {
                        echo "Erro ao conectar ao banco de dados";
                }

        }
}

header("location:telaDespesa.php");

?>