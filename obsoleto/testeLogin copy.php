<?php

session_start();

if(isset($_POST['submit']) && !empty($_POST['login'] && !empty($_POST['senha']))){

    include_once('config.php');
    $login = $_POST['login'];
    $senha = $_POST['senha'];


    $sql = "SELECT * FROM usuario WHERE login = '$login' and senha = '$senha'";
    $result = $pdo->query($sql);
    $row = $result->fetch_assoc();
    $_SESSION['nivel_acesso'] = $row['nivel_acesso']; // Supondo que 'nivel_acesso' é o nome da coluna
    if ($row['nivel_acesso'] == 'admin') {
        header('Location: telaAdmin.php'); // Página para administradores
    } else {
        header('Location: telaHome.php'); // Página para usuários comuns
    }

    $result = $pdo->query($sql);

    if(mysqli_num_rows($result) < 1){
        unset($_SESSION['login']);
        unset($_SESSION['senha']);
        header('Location: telaLogin.php');
    }
    else{
        $_SESSION['login'] = $login;
        $_SESSION['senha'] = $senha;
        $_SESSION['id_usuario'] = 
        header('Location: telaHome.php'); // Redireciona para a página inicial

    }


}
else{
    header('Location: telaLogin.php');
}
