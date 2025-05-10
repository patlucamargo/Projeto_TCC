<?php
session_start();
require 'Classes\Receita.class.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    echo json_encode(['erro' => 'Usuário não autenticado']);
    exit;
}

$id_usuario = $_SESSION['id'];

// Obter mês e ano da requisição
$mes = isset($_POST['mes']) ? intval($_POST['mes']) : date('m');
$ano = isset($_POST['ano']) ? intval($_POST['ano']) : date('Y');

// Instanciar a classe Receita
$receita = new Receita();

// Buscar os valores para o mês e ano especificados
$receitas_pendentes = $receita->receitasPendentesMes($id_usuario, $mes, $ano);
$receitas_recebidas = $receita->receitasRecebidasMes($id_usuario, $mes, $ano);
$total_geral = $receitas_pendentes + $receitas_recebidas;

// Formatar os valores para exibição
$pendentes_formatado = number_format($receitas_pendentes, 2, '.', '');
$recebidas_formatado = number_format($receitas_recebidas, 2, '.', '');
$total_formatado = number_format($total_geral, 2, '.', '');

// Retornar os valores em formato JSON
echo json_encode([
    'pendentes' => $pendentes_formatado,
    'recebidas' => $recebidas_formatado,
    'total' => $total_formatado
]);
?>