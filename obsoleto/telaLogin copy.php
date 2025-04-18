<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <link rel="stylesheet" href="css/login.css">
    
</head>
<body>
    <div>
        <h1>Login</h1>
        <form action="testeLogin.php" method="POST">
            <input type="text" name="login" placeholder ="Username">
            <br><br>
            <input type="password" name="senha" placeholder="Senha">
            <br><br>
            <input class="inputSubmit" type="submit" name="submit" value="Entrar">
            <br><br>
            <a href="formularioCadastro.php">Cadastre-se</a>
        </form>
    </div>
    
    
</body>
</html>