<?php

class Receita{
    private $id_Receita;
    private $categoria;
    private $data_registro;
    private $valor;
    private $numParcelas;
    private $pago;
    private $id_usuario;
    private $pdo;

    public function __construct(){
        $dns = "mysql:dbname=famfinan;host=localhost";
        $username = "root";
        $password = "";

        try {
            $this->pdo = new PDO($dns, $username, $password);
            return true;
        } catch (Exception $e) {
            return false;
        }

    }

    public function getCategoria(){
        return $this->categoria;
    }

    public function setCategoria($categoria){
        $this->categoria = $categoria;
    }

    public function getData_registro(){
        return $this->data_registro;
    }

    public function setData_registro($data_registro){
        $this->data_registro = $data_registro;
    }

    public function getValor(){
        return $this->valor;
    }

    public function setValor($valor){
        $this->valor = $valor;
    }

    public function getNumParcels(){
        return $this->numParcelas;
    }

    public function setNumParcels($numParcelas){
        $this->numParcelas = $numParcelas;
    }

    public function getPago(){
        return $this->pago;
    }

    public function setPago($pago){
        $this->pago = $pago;
    }

    public function getId_usuario(){
        return $this->id_usuario;
    }

    public function setId_usuario($id_usuario){
        $this->id_usuario = $id_usuario
        ;
    }   

    public function somaReceitas($id_usuario){
        $sql = "SELECT SUM(valor) AS total_receitas FROM receitas WHERE id_usuario = :id_usuario";
        $inserir = $this->pdo->prepare($sql);
        $inserir->bindParam(':id_usuario', $id_usuario);
        $inserir->execute();

        $receita = $inserir->fetch();
       
        return $receita['total_receitas'] ?? 0;
    }
    
    public function inserirReceita($id, $categoria, $valor, $data_registro, $numParcelas, $pago){
        $sql = "INSERT INTO receitas set categoria = :ca, valor = :vl, data_registro = :dr, numParcelas = :np, pago  = :pg, id_usuario = :id";

        $inserir = $this->pdo->prepare($sql);

        $inserir -> bindValue(":ca", $categoria);
        $inserir -> bindValue(":vl", $valor);
        $inserir -> bindValue(":dr", $data_registro);
        $inserir -> bindValue(":pg", $pago);
        $inserir -> bindValue(":np", $numParcelas);
        $inserir -> bindValue(":id", $id);

        return $inserir->execute();
    }

    public function alterarReceita($id, $categoria, $valor, $data_registro, $numParcelas, $pago){
        $sql = "UPDATE receitas set categoria = :ca, valor = :vl, data_registro = :dr, numParcelas = :np, pago  = :pg WHERE id = :id";

        $alterar = $this->pdo->prepare($sql);

        $alterar -> bindValue(":ca", $categoria);
        $alterar -> bindValue(":vl", $valor);
        $alterar -> bindValue(":dr", $data_registro);
        $alterar -> bindValue(":pg", $pago);
        $alterar -> bindValue(":np", $numParcelas);
        $alterar -> bindValue(":id", $id);

        return $alterar->execute();
    }

    public function receitasPendentes($id){
        $sql = "SELECT SUM(valor) AS total_receitas FROM receitas WHERE id_usuario = :id AND pago = '0'";
        $sql = $this->pdo->prepare($sql);
        $sql ->bindValue(":id", $id);
        $sql->execute();

        $receita = $sql->fetch();
       
        return $receita['total_receitas'] ?? 0;
    }

    public function receitasRecebidas($id){
        $sql = "SELECT SUM(valor) AS total_recebidos FROM receitas WHERE id_usuario = :id AND pago = '1' ";
        $sql = $this->pdo->prepare($sql);
        $sql ->bindValue(":id", $id);

        $sql->execute();

        $recebidos = $sql->fetch();
        return $recebidos['total_recebidos'] ?? 0;
        

    }

    public function receitas($id){
        $consulta = "SELECT * FROM receitas WHERE id_usuario = :id";
        $resultado = $this->pdo->prepare($consulta);
        $resultado ->bindValue(":id", $id);

        $resultado->execute();
        return $resultado->fetchAll();
    }

    public function deletreceitas($id){
        $consulta = "DELETE FROM receitas WHERE id = :id";
        $resultado = $this->pdo->prepare($consulta);
        $resultado ->bindValue(":id", $id);

        $resultado->execute();
        return $resultado->fetchAll();
    }

    public function receitasPorMes($id, $mes, $ano) {
        $consulta = "SELECT * FROM receitas WHERE id_usuario = :id AND MONTH(STR_TO_DATE(data_registro, '%Y-%m-%d')) = :mes AND YEAR(STR_TO_DATE(data_registro, '%Y-%m-%d')) = :ano";
        $stmt = $this->pdo->prepare($consulta);
        $stmt->bindValue(":id", $id);
        $stmt->bindValue(":mes", $mes);
        $stmt->bindValue(":ano", $ano);
        $stmt->execute();
        return $stmt->fetchAll();
      }


}
