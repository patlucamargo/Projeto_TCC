<?php

class Usuario{
    private $id;
    private $login;
    private $email;
    private $senha;
    private $nivel_acesso;
    private $grupo_familiar;
    private $pdo;

    public function __construct()
    {
        $dns = "mysql:dbname=famfinan;host=localhost";
        $username = "root";
        $password = "";

        try {
            $this->pdo = new PDO($dns, $username, $password);
           
            return true;
        } catch (Exception $e) {
            echo "Erro ao conectar ao banco de dados: ";
            exit;
        }

    }


    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail($email)
    {
        $this->email = $email;
    }

    public function getSenha()
    {
        return $this->senha;
    }

    public function setSenha($senha)
    {
        $this->senha = $senha;
    }

    public function getNivel_acesso()
    {
        return $this->nivel_acesso;
    }

    public function setNivel_acesso($nivel_acesso)
    {
        $this->nivel_acesso = $nivel_acesso;
    }

    public function getGrupo_familiar()
    {
        return $this->grupo_familiar;
    }

    public function setGrupo_familiar($grupo_familiar)
    {
        $this->grupo_familiar = $grupo_familiar;
    }


    public function cadastrarUsuario( $nome, $email, $grupo_familiar,  $senha, $login ){
        
        $sql = "INSERT INTO usuarios SET nome_completo=:n, email=:e, grupo_familiar = :g, senha = :s, login= :l ";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':n', $nome);
        $stmt->bindParam(':e', $email);
        $stmt->bindParam(':g', $grupo_familiar);
        $stmt->bindParam(':s', md5( $senha) );
        $stmt->bindParam(':l', $login);
        
        return $stmt->execute();

    }

    public function chkUser($email){
        $sql = "SELECT * FROM usuarios WHERE email = :email";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
    
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $result = $stmt->fetch();
            return $result;
        }else{
            return array();
        }
    }

    public function chkUserPass($email, $senha){
        $sql = "SELECT * FROM usuarios WHERE email = :email AND senha = :senha";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $result = $stmt->fetch();
            return $result;

        }else{
            return array();
        }
    }

    public function somaDespesasReceitas($email, $tipo){
        $sql = "SELECT id FROM usuarios WHERE email = :e";
        $stmt = $this->pdo->prepare( $sql );
        $stmt->bindParam(":e", $email);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            $user = $result_user->fetch_assoc();
            $user_id = $user['id'];

            // Despesas
            if($tipo == "D"){
                $sql = "SELECT SUM(valor) AS total_despesas FROM despesas WHERE id_usuario = :i";
            }else{ 
                $sql = "SELECT SUM(valor) AS total_receitas FROM despesas WHERE id_usuario = :i";
            }
            $stmt = $this->pdo->prepare($sql);
            $stmt->bindParam(":i", $user_id);
            $stmt->execute();
            $total = 0;

            if ($stmt->rowCount() > 0) {
                $row = $stmt->fetch_assoc();
                if( $tipo == "D"){
                    $total = $row['total_despesas'] ?: 0;
                }else{
                    $total = $row['total_receitas'] ?: 0;
                }    
                return $total;
            }


    }

}
}