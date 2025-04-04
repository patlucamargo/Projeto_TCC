<?php

class Usuario{
    private $id;
    private $login;
    private $senha;
    private $nivel_acesso;
    private $pdo;

    public function getLogin()
    {
        return $this->login;
    }

    public function setLogin($login)
    {
        $this->login = $login;
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
        $this->login = $nivel_acesso;
    }

    public function __construct()
    {
        $dns = "msql:dbname=famfinan;host=localhost";
        $username = "root";
        $password = "";

        try {
            $this->pdo = new PDO($dns, $username, $password);
            return true;
        } catch (Exception $e) {
            echo "Erro ao conectar ao banco de dados: ";
            return false;
        }

    }

    public function cadastrarUsuario(){

    }

    public function chkUser($login, $senha){
        $sql = "SELECT * FROM usuarios WHERE login = :login AND senha = :senha";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':login', $login);
        $stmt->bindParam(':senha', $senha);
        $stmt->execute();

        if($stmt->rowCount() > 0){
            $result = $stmt->fetch();
            return $result;

        }else{
            return array();
        }
    }

}