<?php

session_start();

if (isset($_POST['submit']) && !empty($_POST['login'] && !empty($_POST['senha']))) {

    include_once('Usuario.class.php');
    $login = $_POST['login'];
    $senha = $_POST['senha'];

    $conecta = $usuario = new Usuario();
    
    if (!$conecta) {
        echo "Erro ao conectar ao banco de dados";
    } else {
        $chkUser = $usuario->chkUser($login, $senha);
        if (empty($chkUser)) {
            echo "Login ou senha inválidos";
        } else {
            $_SESSION['login'] = $chkUser['login'];
            $_SESSION['id_usuario'] = $chkUser['id_usuario'];
            $_SESSION['nivel_acesso'] = $chkUser['nivel_acesso'];

            if ($chkUser['nivel_acesso'] == 'admin') {
                header('Location: telaAdmin.php'); // Página para administradores
            } else {
                header('Location: telaHome.php'); // Página para usuários comuns
            }
        }
    }
}
