<?php

class Receitas
{
    private $id_Receita;
    private $categoria;
    private $data_registro;
    private $valor;
    private $numParcels;
    private $pago;
    private $id_usuario;
    private $pdo;

    public function getCategoria()
    {
        return $this->categoria;
    }

    public function setCategoria($categoria)
    {
        $this->categoria = $categoria;
    }

    public function getData_registro()
    {
        return $this->data_registro;
    }

    public function setData_registro($data_registro)
    {
        $this->data_registro = $data_registro;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function getNumParcels()
    {
        return $this->numParcels;
    }

    public function setNumParcels($numParcels)
    {
        $this->numParcels = $numParcels;
    }

    public function getPago()
    {
        return $this->pago;
    }

    public function setPago($pago)
    {
        $this->pago = $pago;
    }

    public function getId_usuario()
    {
        return $this->id_usuario;
    }

    public function setId_usuario($id_usuario)
    {
        $this->id_usuario = $id_usuario
        ;
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

    public function somaReceitas($id_usuario)
    {
        $sql = "SELECT SUM(valor) FROM receitas WHERE id_usuario = :id_usuario";
        $inserir = $this->pdo->prepare($sql);
        $inserir->bindParam(':id_usuario', $id_usuario);
        $inserir->execute();
    }

}
