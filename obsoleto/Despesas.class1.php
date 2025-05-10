<?php

class Despesas
{
    private $id_Despesa;
    private $categoria;
    private $descricao;
    private $valor;
    private $dataVenc;
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

    public function getDescricao()
    {
        return $this->descricao;
    }

    public function setDescricao($descricao)
    {
        $this->descricao = $descricao;
    }

    public function getValor()
    {
        return $this->valor;
    }

    public function setValor($valor)
    {
        $this->valor = $valor;
    }

    public function getDataVenc()
    {
        return $this->dataVenc;
    }

    public function setDataVenc($dataVenc)
    {
        $this->dataVenc = $dataVenc;
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

    public function somaDespesas($id_usuario)
    {
        $sql = "SELECT SUM(valor) FROM despesas WHERE id_usuario = :id_usuario";
        $inserir = $this->pdo->prepare($sql);
        $inserir->bindParam(':id_usuario', $id_usuario);
        $inserir->execute();
    }

}
