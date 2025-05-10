<?php

class GrupoFamiliar
{
    private $id_grupo_familiar;
    private $administrador;
    private $id_usuario;
    private $pdo;

    public function getAdministrador()
    {
        return $this->administrador;
    }

    public function setAdministrador($administrador)
    {
        $this->administrador = $administrador;
    }

    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    public function setId_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario;
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
}
