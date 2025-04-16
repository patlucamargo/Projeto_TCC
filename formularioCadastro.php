<?php

if (isset($_POST['enviar'])) {
    require 'Usuario.class.php';
    $con = $usuario = new Usuario();    
    if(!$con){
       echo "<script>
                confirm('Erro ao conectar com o banco, tente mais tarde'
            </script>";

       header("location: telalogin.php");

    }else{
        $nome       = $_POST['nome'];
        $email      = $_POST['email'];
        $senha      = $_POST['senha'];
        $nascimento = $_POST['dat_nasc'];
        $login      = $_POST['login'];
        $grupo      = $_POST['grupo_familiar'];
        $senha      = md5($senha);

        $chkUs = $usuario->chkUser($email);
        if (!$chkUs){   
            $us = $usuario->cadastrarUsuario( $nome, $email, $nascimento, $grupo,  $senha, $login );
        }else{
            echo "<script>
                confirm('Erro ao conectar com o banco, tente mais tarde'
            </script>";
        }

        if(!$us){
            echo "<h1>Erro ao cadastrar usuário!</h1>";            
        }
    }

    header('Location: telaLogin.php');
}

?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulário | GN</title>
    <style>
        body {
            font-family: Arial, Helvetica, sans-serif;
            background-image: linear-gradient(45deg, #f0f0f0, #ebc4f7);
        }
        .box {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color:  #e79eeb;
            padding: 15px;
            border-radius: 20px;
            width: 350px;        
            color: white;
        }
        fieldset {
            border: 3px solid darkorchid;
        }
        legend {
            border: 1px darkorchid;
            padding: 10px;
            text-align: center;
            background-color: darkorchid;
            border-radius: 8px;
            color: white;
        }
        .inputBox {
            position: relative;
        }
        .inputUser {
            background: none;
            border: none;
            border-bottom: 1px solid white;
            outline: none;
            color: white;
            font-size: 15px;
            width: 100%;
            letter-spacing: 2px;
        }
        .labelInput {
            position: absolute;
            left: 0px;
            top: 0px;
            pointer-events: none;
            transition: 1s;
        }
        .inputUser:focus ~ .labelInput, 
        .inputUser:valid ~ .labelInput {
            top: -20px;
            color: darkorchid;
            font-size: 12px;
        }
        #data_nascimento {
            border: none;
            padding: 8px;
            border-radius: 10px;
            outline: none;
            font-size: 15px;
        }
        #submit {
            background-color: darkorchid;
            width: 100%;
            border: none;
            padding: 15px;
            color: white;
            border-radius: 7px;
            font-size: 15px;
            cursor: pointer;
        }
        #submit:hover {
            background-color: rgb(146, 11, 146);
        }
    </style>
</head>
<body>

<a href="telaLogin.php">Voltar</a>

    <div class="box">
        <form method="POST">
            <fieldset>
                <legend><b>Formulário Cadastro</b></legend>   
                <br>
                <div class="inputBox">
                    <input type="text" name="nome" id="nome" class="inputUser" required>
                    <label for="nome" class="labelInput">Nome completo</label>
                </div>
                
                <br><br>
                <div class="inputBox">
                    <input type="text" name="email" id="email" class="inputUser" required>
                    <label for="email" class="labelInput">Email</label>
                </div>
                <br><br>
                     
                <label for="data_nasc"><b>Data de Nascimento</b></label>
                <input type="date" name="dat_nasc" id="data_nasc" required>
                <br><br> 

                <div class="inputBox">
                    <input type="text" name="grupo_familiar" id="grupo_familiar" class="inputUser" required>
                    <label for="grupo_familiar" class="labelInput">Grupo Familiar</label>                
                </div>
                <br><br>

                <div class="inputBox">
                    <input type="text" name="login" id="login" class="inputUser" required>
                    <label for="login" class="labelInput">Login</label>                
                </div>
                <br><br>
               
                <div class="inputBox">
                    <input type="password" name="senha" id="senha" class="inputUser" required>
                    <label for="senha" class="labelInput">Senha</label>
                </div>
                <br><br>
                <input type="submit" name="enviar" id="submit">

            </fieldset> 
        </form>
    </div>
</body>
</html>
