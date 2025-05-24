<?php

class Despesa
{
    private $id_Despesa;
    private $categoria;
    private $descricao;
    private $tipoDespesa;
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
            return $this->pdo !== null;
        } catch (Exception $e) {
            echo "Erro ao conectar ao banco de dados: ";
            return false;
        }
    }

    public function getCategoria(){
        return $this->categoria;
    }

    public function setCategoria($categoria){
        $this->categoria = $categoria;
    }

    public function getDescricao(){
        return $this->descricao;
    }

    public function setDescricao($descricao){
        $this->descricao = $descricao;
    }

     public function getTipoDespesa(){
        return $this->tipoDespesa;
    }

    public function setTipoDespesa($tipoDespesa){
        $this->tipoDespesa = $tipoDespesa;
    }

    public function getValor(){
        return $this->valor;
    }

    public function setValor($valor){
        $this->valor = $valor;
    }

    public function getDataVenc(){
        return $this->dataVenc;
    }

    public function setDataVenc($dataVenc){
        $this->dataVenc = $dataVenc;
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

    public function somaDespesas($id_usuario)
    {
        $sql = "SELECT SUM(valor) AS total_despesas FROM despesas WHERE id_usuario = :id_usuario";
        $inserir = $this->pdo->prepare($sql);
        $inserir->bindValue(':id_usuario', $id_usuario);
        $inserir->execute();

        $despesa = $inserir->fetch();

        return $despesa['total_despesas'] ?? 0;

    }

    public function inserirDespesa($id, $categoria, $descricao, $tipoDespesa, $valor, $dataVenc, $pago){
        $sql = "INSERT INTO despesas set categoria = :ca, descricao = :de, tipoDespesa = :td, valor = :vl, dataVenc = :dv, pago  = :pg, id_usuario = :id";

        $inserir = $this->pdo->prepare($sql);

        $inserir -> bindValue(":ca", $categoria);
        $inserir -> bindValue(":de", $descricao);
        $inserir -> bindValue(":td", $tipoDespesa);
        $inserir -> bindValue(":vl", $valor);
        $inserir -> bindValue(":dv", $dataVenc);
        $inserir -> bindValue(":pg", $pago);
        $inserir -> bindValue(":id", $id);

        return $inserir->execute();
    }

     public function alterarDespesa($id, $categoria, $tipoDespesa, $descricao,   $valor, $dataVenc, $pago)
    {
        $sql = "UPDATE despesas set categoria = :ca, tipoDespesa = :td, descricao = :dc,  valor = :vl, dataVenc = :dv, pago  = :pg WHERE id = :id";

        $alterar = $this->pdo->prepare($sql);

        $alterar->bindValue(":ca", $categoria);
        $alterar->bindValue(":td", $tipoDespesa);
        $alterar->bindValue(":dc", $descricao);
        $alterar->bindValue(":vl", $valor);
        $alterar->bindValue(":dv", $dataVenc);
        $alterar->bindValue(":pg", $pago);
        $alterar->bindValue(":id", $id);

        return $alterar->execute();
    }


    public function despesasPendentes($id){
        $sql = "SELECT SUM(valor) AS total_pendentes FROM despesas WHERE id_usuario = :id AND pago = '0' ";
        $sql = $this->pdo->prepare($sql);
        $sql ->bindValue(":id", $id);

        $sql->execute();

        $despesa = $sql->fetch();
       
        return $despesa['total_pendentes'] ?? 0;

    }

    public function despesasRecebidas($id){
        $sql = "SELECT SUM(valor) AS total_recebidos FROM despesas WHERE id_usuario = :id AND pago = '1' ";
        $sql = $this->pdo->prepare($sql);
        $sql ->bindValue(":id", $id);

        $sql->execute();

        $recebidos = $sql->fetch();
        return $recebidos['total_recebidos'] ?? 0;
       
    }

    public function despesas($id)
    {
        $consulta = "SELECT * FROM despesas WHERE id_usuario = :id";
        $resultado = $this->pdo->prepare($consulta);
        $resultado->bindValue(":id", $id);

        $resultado->execute();
        return $resultado->fetchAll();
    }

    public function deletdespesas($id)
    {
        $consulta = "DELETE FROM despesas WHERE id = :id";
        $resultado = $this->pdo->prepare($consulta);
        $resultado->bindValue(":id", $id);

        $resultado->execute();
        return $resultado->fetchAll();
    }

    public function despesasPendentesMes($id_usuario, $mes, $ano)
    {
        $sql = "SELECT SUM(valor) as total_pendente 
                FROM despesas 
                WHERE id_usuario = :id_usuario 
                  AND pago = 0
                  AND MONTH(dataVenc) = :mes 
                  AND YEAR(dataVenc) = :ano";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->bindValue(':mes', $mes);
        $stmt->bindValue(':ano', $ano);
        $stmt->execute();

        $despesa = $stmt->fetch();
        return $despesa['total_pendente'] ?? 0;
    }

    public function despesasRecebidasMes($id_usuario, $mes, $ano)
    {
        $sql = "SELECT SUM(valor) as total_recebido 
                FROM despesas 
                WHERE id_usuario = :id_usuario 
                  AND pago = 1
                  AND MONTH(dataVenc) = :mes 
                  AND YEAR(dataVenc) = :ano";
        $stmt = $this->pdo->prepare($sql);
        $stmt->bindValue(':id_usuario', $id_usuario);
        $stmt->bindValue(':mes', $mes);
        $stmt->bindValue(':ano', $ano);
        $stmt->execute();

        $despesa = $stmt->fetch();
        return $despesa['total_recebido'] ?? 0;
    }

    public function obterDespesasPorCategoriaMes($mes, $ano)
{
                 
        $sql = "SELECT categoria, SUM(valor) AS total
                FROM despesas
                WHERE MONTH(dataVenc) = :mes AND YEAR(dataVenc) = :ano
                GROUP BY categoria
                ORDER BY total DESC";

        $stmt = $this->pdo->prepare($sql);
        $stmt->bindParam(':mes', $mes, PDO::PARAM_INT);
        $stmt->bindParam(':ano', $ano, PDO::PARAM_INT);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);

        
    }
}

?>