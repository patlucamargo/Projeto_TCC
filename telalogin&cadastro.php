<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login</title>
    <link rel="stylesheet" href="css/styleTelaLoginCadastro.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css"
        integrity="sha384-oS3vJWv+0UjzBfQzYUhtDYW+Pj2yciDJxpsK1OYPAYjqT085Qq/1cq5FLXAZQ7Ay" crossorigin="anonymous">
        <link rel="shortcut icon" href="imagem/favicon.ico" type="image/x-icon">
</head>
<body>
    <nav class="navbar">
        <div class="logo-container">
          <img src="imagem/logo_Fam_Finan.png" alt="Logo Organize">
          <span class="logo-text"><strong>Family Financing</strong></span>
          </div>
          </nav>
          <div class="container">
          <div class="content first-content">    <!--  Primeiro conteudo - Primeira parte -->
                <div class="first-column">     <!--  Primeira coluna -->
                <h2 class="title title-primary">Bem vindo de volta!</h2>
                <p class="description description-primary">Para se manter conectado conosco</p>
                <p class="description description-primary">por favor faça login com suas informações pessoais</p>
                <button id="signin" class="btn btn-primary">Entrar</button>
                </div>    
                <div class="second-column">    <!--  Segunda coluna -->
                <h2 class="title title-second">Criar uma conta</h2>
                
                <form class="form">           <!--  Inicio formulário de cadastro-->
                    <label class="label-input" for="">
                        <i class="far fa-user icon-modify"></i>
                        <input type="text" placeholder="Nome">
                    </label>
                    
                    <label class="label-input" for="">
                        <i class="far fa-envelope icon-modify"></i>
                        <input type="email" placeholder="E-mail">
                    </label>
                    
                    <label class="label-input" for="">
                        <i class="fas fa-lock icon-modify"></i>
                        <input type="password" placeholder="Senha">
                    </label>

                    <label class="label-input" for="">
                        <i class="far fa-user icon-modify"></i>
                        <input type="text" placeholder="Como gostaria de ser chamado">
                    </label>
                    
                    <button class="btn btn-second">Cadastrar</button>        
                </form>                    <!--  Fim formulário-->
            </div>                         <!--  Fim da second column -->
        </div>                             <!--  Fim da first content -->


        <!-- Inicio da segunda parte com o JS - Segundo conteudo -->
            <div class="content second-content">                         <!--  Segundo conteudo -->
            <div class="first-column">                                   <!--  Primeira coluna do segundo conteudo-->
                <h2 class="title title-primary">Olá amigo!</h2>
                <p class="description description-primary">Insira seus dados pessoais e comece</p>
                <p class="description description-primary">Sua jornada conosco</p>
                <button id="signup" class="btn btn-primary">Inscrever-se</button>
            </div>
            <div class="second-column">             
                <h2 class="title title-second">Faça o seu login</h2>     <!--  Segunda coluna do segundo conteudo-->
                
                <form action="testeLogin.php" method="POST" class="form">  <!--  Início do formulario de Login-->
                
                    <label class="label-input">
                        <i class="far fa-envelope icon-modify"></i>
                        <input type="text" name="email" placeholder ="Informe o seu email">
                    </label>
                
                    <label class="label-input" for="">
                        <i class="fas fa-lock icon-modify"></i>
                        <input type="password" name="senha" placeholder="Informe sua Senha">
                    </label>
                
                    <a class="password" href="#">Esqueceu sua senha?</a>
                    <button class="btn btn-second" name="submit">Entrar</button>
                </form>  <!-- Fim do formulario -->
            </div>       <!-- Fim da second column -->
        </div>           <!-- Fim da second-content -->
    </div>
    <script src="js/app.js"></script>
</body>
</html>

