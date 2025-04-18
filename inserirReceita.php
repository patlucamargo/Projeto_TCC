<?php
session_start();
include "Receita.class.php";
$rec = $receita = new Receita();

if(!$rec){
        echo "Erro ao conectar ao banco de dados";
        exit;
}else{
        if ((!isset($_SESSION['login']) ) && (!isset($_SESSION['senha']))) {
                unset($_SESSION['login']);
                unset($_SESSION['senha']);
                header('Location: telalogin.php');
             
        }else{
                if(isset($_POST['submit'])){
                        // Obtém os dados do formulário
                        $valor          = $_POST['valor'];
                        $categoria      = $_POST['categoria'];
                        $dataRegistro   = $_POST['dataRegistro']; // Usa a data atual se não for informada
                        $numParcelas    = $_POST['numParcelas'] ?: 1; // Define 1 parcela como padrão se não for informada
                        $pago           = isset($_POST['pago']) ? 1 : 0;
                        $id             = $_SESSION['id'];
                
                        // Prepara o comando SQL para inserção
                       
                        $receita->inserirReceita($id, $categoria, $valor, $dataRegistro, $numParcelas, $pago);
                
                }else{
                        echo "Erro ao conectar ao banco de dados";
                }       
       
}
}
        header("location:telaReceita.php");

?>
