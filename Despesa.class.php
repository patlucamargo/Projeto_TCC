<?php

class Despesa
{
    private $id_Despesa;
    private $categoria;
    private $descricao;
    private $valor;
    private $dataVenc;
    private $pago;
    private $id_usuario;
    private $pdo;
    
    public function __construct(){
        $dns      = "mysql:dbname=famfinan;host=localhost";
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

    public function somaDespesas($id_usuario)
    {
        $sql = "SELECT SUM(valor) FROM despesas WHERE id_usuario = :id_usuario";
        $inserir = $this->pdo->prepare($sql);
        $inserir->bindValue(':id_usuario', $id_usuario);
        return $inserir->execute();
    }

    public function inserirDespesa($id, $categoria, $descricao, $valor, $dataVenc, $pago){
        $sql = "insert into despesas set categoria = :ca, descricao = :de, valor = :vl, dataVenc = :dv, pago  = :pg WHERE id_usuario = :id";

        $inserir = $pdo->prepare($sql);

        $inserir -> bindValue(":ca", $categoria);
        $inserir -> bindValue(":de", $descricao);
        $inserir -> bindValue(":vl", $valor);
        $inserir -> bindValue(":dv", $dataVenc);
        $inserir -> bindValue(":pg", $pago);
        $inserir -> bindValue(":id", $id);

        return $inserir->execute();
    }

    public despesasPendentes($id){
        $sql = "SELECT SUM(valor) AS total_pendentes FROM despesas WHERE id_usuario = :id AND pago = '0' ";
        $sql-> $pdo->prepare($sql);
        $sql ->bindValue(":id", $id);

        if( $sql->rowCount() > 0 ){
            $pendente = $sql->fetch();
            return $pendente['total_pendentes'];
        }else{
            return 0;
        }

    }

}

//falta implementar
// Despesas Recebidas
// $sql_recebidas = "SELECT SUM(valor) AS total_recebidas FROM despesas WHERE pago = '1'";
// $result_recebidas = $pdo->query($sql_recebidas);

// $total_recebidas = 0;
// if ($result_recebidas->num_rows > 0) {
//   $row = $result_recebidas->fetch_assoc();
//   $total_recebidas = $row['total_recebidas'] ?: 0;
// }

// // Total Geral
// $total_geral = $total_pendentes + $total_recebidas;
