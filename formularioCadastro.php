<?php

if (isset($_POST['enviar'])) {
    require 'Classes/Usuario.class.php';
    $con = $usuario = new Usuario();    
    if(!$con){
       echo "<script>
                confirm('Erro ao conectar com o banco, tente mais tarde'
            </script>";

       header("location: telalogin&cadastro.php");

    }else{
        $nome           = $_POST['nome'];
        $email          = $_POST['email'];
        $senha          = $_POST['senha'];
        $login          = $_POST['login'];
        $grupo_familiar = $_POST['grupo_familiar'];
        $senha          = md5($senha);

        $chkUs = $usuario->chkUser($email);
        if (!$chkUs){   
            $us = $usuario->cadastrarUsuario( $nome, $email, $grupo_familiar,  $senha, $login );
        }else{
            echo "<script>
                confirm('Erro ao conectar com o banco, tente mais tarde'
            </script>";
        }

        if(!$us){
            echo "<h1>Erro ao cadastrar usuário!</h1>";            
        }
    }

    header('Location: telalogin&cadastro.php');
}


