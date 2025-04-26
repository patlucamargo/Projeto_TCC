<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <link rel="stylesheet" href="css/login.css">
    
</head>
<body>
    <div class="container">
        <h1>Login</h1>
        <form action="testeLogin.php" method="POST">
            <input type="text" name="email" placeholder ="Informe o seu email">
            <br><br>
            <input type="password" name="senha" placeholder="Informe sua Senha">
            <br><br>
            <input class="inputSubmit" type="submit" name="submit" value="Entrar">
            <br><br>
            <a href="formularioCadastro.php">Cadastre-se</a>
        </form>
    </div>
    
    
</body>
</html>