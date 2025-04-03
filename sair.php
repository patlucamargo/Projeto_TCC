<?php
    session_start();
    unset($_SESSION['login']);
    unset($_SESSION['senha']);
    header('Location: telaLogin.php');
?>