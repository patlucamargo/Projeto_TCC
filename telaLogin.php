<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tela de Login</title>
    <style>
        body{
            font-family: Arial, Helvetica, sans-serif;
            background-image: linear-gradient(45deg, #f0f0f0, #ebc4f7);
        }
        div{
            background-color:  #e79eeb;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            padding: 70px;
            padding-top: 30px;
            padding-bottom: 30px;
            border-radius: 20px;
            color: white;
            text-align: center;
        }
        input{
            padding: 15px;
            border: none;
            outline: none;
            font-size: 15px;
        }
       
        .inputSubmit{
            background-color: darkorchid;
            border:none;
            padding: 15px;
            width: 100%;
            border-radius: 10px;
            color: white;
            font-size: 15px;
        }

        .inputSubmit:hover{
            background-color: rgb(146, 11, 146);
            cursor: pointer;
        }

        a{
            text-decoration: none;
        }
        a:hover{
            color: white;
        }

    </style>
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