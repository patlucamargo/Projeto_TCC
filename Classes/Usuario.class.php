<?php

class Usuario{
    private $id;
    private $login;
    private $senha;
    private $grupo_familiar;
    private $nivel_acesso;
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
            return false;
        }

    }


    public function getLogin(){
        return $this->login;
    }

    public function setLogin($login){
        $this->login = $login;
    }

    public function getSenha(){
        return $this->senha;
    }

    public function setSenha($senha){
        $this->senha = $senha;
    }

    public function getGrupo_familiar(){
        return $this->grupo_familiar;
    }

    public function setGrupo_familiar($grupo_familiar){
        $this->grupo_familiar = $grupo_familiar;
    }

    public function getNivel_acesso(){
        return $this->nivel_acesso;
    }

    public function setNivel_acesso($nivel_acesso){
        $this->login = $nivel_acesso;
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

    public function chkUserPass($login, $senha){
        $sql = "SELECT * FROM usuarios WHERE login = :login AND senha = :senha";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':senha', md5( $senha) );
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $result = $stmt->fetch();
            return $result;

        }else{
            return array();
        }
    }

public function updateUsuario( $id, $nome, $email, $login ){
        
        $sql = "UPDATE usuarios SET nome_completo=:n, email=:e, login= :l WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':n', $nome);
        $stmt->bindParam(':e', $email);
        $stmt->bindParam(':l', $login);
        
        return $stmt->execute();

    }

    public function usuario($id, $nome = null, $email = null, $login = null, $grupo_familiar = null){

        $consulta = "SELECT * FROM usuarios WHERE id = :id";
        $resultado = $this->pdo->prepare($consulta);
        $resultado->bindValue(":id", $id);
        $resultado->execute();
        
        if($resultado->rowCount() > 0){
            return $resultado->fetch(PDO::FETCH_ASSOC);
        }
        
        return false;
    }
    
    public function getMembrosGrupo($grupo_familiar, $excluir_id = null){
        $sql = "SELECT id, nome_completo, contribuicao_percent FROM usuarios WHERE grupo_familiar = :grupo";
        
        if($excluir_id){
            $sql .= " AND id != :excluir_id";
        }
        
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':grupo', $grupo_familiar);
        
        if($excluir_id){
            $stmt->bindParam(':excluir_id', $excluir_id);
        }
        
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
          
    public function deletUsuario($id)
    {
        $consulta = "DELETE FROM usuario WHERE id = :id";
        $resultado = $this->pdo->prepare($consulta);
        $resultado->bindValue(":id", $id);

        $resultado->execute();
        return $resultado->fetchAll();
    }

}