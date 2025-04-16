<?php

session_start();

if (isset($_POST['submit']) && !empty($_POST['email'] && !empty($_POST['senha']))) {
    $email = $_POST['email'];
    $senha = md5( $_POST['senha']);

    
    include_once('Usuario.class.php');
   
    $conecta = $usuario = new Usuario();
    
    if (!$conecta) {
        echo "<script>
        confirm('Erro ao conectar ao banco de dados')
    </script>";
    } else {
        $chkUser = $usuario->chkUser( $email );

        if (empty($chkUser)) {
            echo "<script>
                        confirm('Email ou senha invalidos')
                  </script>";
        } else {
            $_SESSION['email']        = $chkUser['email'];
            $_SESSION['login']        = $chkUser['login'];
            $_SESSION['id']           = $chkUser['id'];
            $_SESSION['nivel_acesso'] = $chkUser['nivel_acesso'];
            $_SESSION['senha']        = $chkUser['senha'];

            if ($chkUser['nivel_acesso'] == 'admin') {
                header('Location: telaAdmin.php'); // Página para administradores
            } else {
                header('Location: telaHome.php'); // Página para usuários comuns
            }
        }
    }
}
