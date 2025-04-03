<?php

if (!empty($_GET['id'])) {
    
    include_once('config.php');

    $id = $_GET['id'];

    $sqlSelect = "SELECT * FROM receitas WHERE id=$id";

    $result = $pdo->query($sqlSelect);

    if($result->num_rows > 0){
       
        $sqlDelete = "DELETE FROM receitas where id=$id";
        $resultDelete = $pdo->query($sqlDelete);    
        
    }      
}

header('Location: telaReceita.php');


?>