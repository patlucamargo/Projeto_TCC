<?php
session_start();
include "Classes\Usuario.class.php";

$user = $usuario = new Usuario();

if (!$user) {
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
            $nome = $_POST['nome_completo'];
            $login = $_POST['login'];
            $grupo_familiar = $_POST['grupo_familiar'];
            
            $usuario->updateUsuario($id, $nome, $nome, $login);
            
            
        } else {
            echo "Erro ao conectar ao banco de dados";

        }

    }
}

?>