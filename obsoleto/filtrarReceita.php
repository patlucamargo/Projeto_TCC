<?php
session_start();
require 'Classes\Receita.class.php';

if (!isset($_SESSION['id'])) {
  echo "Erro ao conectar ao banco de dados";
  exit;
}

$id_usuario = $_SESSION['id'];
$mes = $_POST['mes'];
$ano = $_POST['ano'];

$receita = new Receita();
$receitas = $receita->receitasPorMes($id_usuario, $mes, $ano);

// Soma os valores
$pendentes = 0;
$recebidas = 0;

foreach ($receitas as $r) {
  if ($r['pago'] == '1') {
    $recebidas += $r['valor'];
  } else {
    $pendentes += $r['valor'];
  }
}

echo json_encode([
  'receitas' => $receitas,
  'pendentes' => $pendentes,
  'recebidas' => $recebidas,
  'total' => $pendentes + $recebidas
]);
