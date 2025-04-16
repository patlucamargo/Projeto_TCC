<?php
session_start();
require "Despesa.class.php";

$desp = $despesa = new Despesa();

if(!$desp){
   echo "Erro ao conectar com o banco! Tente mais tarde";
   exit;
}else{

        if ((!isset($_SESSION['login']) == true) and (!isset($_SESSION['senha']) == true)) {
                unset($_SESSION['login']);
                unset($_SESSION['senha']);
                header('Location: telalogin.php');
             
        }else{
                // Obtém os dados do formulário
                $categoria = $_POST['categoria'];
                $descricao = $_POST['descricao'];
                $valor = $_POST['valor'];
                $dataVenc = $_POST['dataVenc'];
                $pago = isset($_POST['pago']) ? 1 : 0;

                $id = $_SESSION['id_usuario'];
                $despesa->inserirDespesa($id, $categoria, $descricao, $valor, $dataVenc, $pago);
      
        }
}



header("location:telaDespesa.php");

?>
