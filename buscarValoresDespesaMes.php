<?php
session_start();


ini_set('display_errors', 0);
error_reporting(0);

header('Content-Type: application/json');

$arquivoClasse = 'classes/Despesa.class.php';

// Verifica se o arquivo existe
if (!file_exists($arquivoClasse)) {
    echo json_encode([
        'pendentes' => 0,
        'recebidas' => 0,
        'total' => 0,
        'erro' => 'Arquivo Despesa.class.php não encontrado.'
    ]);
    exit;
}
require 'Classes\Despesa.class.php';

// Verificar se o usuário está logado
if (!isset($_SESSION['id'])) {
    echo json_encode(['erro' => 'Usuário não autenticado']);
    exit;
}

$id_usuario = $_SESSION['id'];

$mes = isset($_POST['mes']) ? intval($_POST['mes']) : date('m');
$ano = isset($_POST['ano']) ? intval($_POST['ano']) : date('Y');

$despesa = new Despesa();

// Buscar os valores para o mês e ano especificados
$despesas_pendentes = $despesa->despesasPendentesMes($id_usuario, $mes, $ano);
$despesas_recebidas = $despesa->despesasRecebidasMes($id_usuario, $mes, $ano);
$total_geral = $depesas_pendentes + $despesas_recebidas;

// Formatar os valores para exibição
$pendentes_formatado = number_format($despesas_pendentes, 2, '.', '');
$recebidas_formatado = number_format($despesas_recebidas, 2, '.', '');
$total_geral_formatado = number_format($total_geral, 2, '.', '');

echo json_encode([
    'pendentes' => $pendentes_formatado,
    'recebidas' => $recebidas_formatado,
    'total' => $total_geral_formatado
]);

?>