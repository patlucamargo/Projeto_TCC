<?php

if (!empty($_GET['id'])) {
    
    include_once('config.php');

    $id = $_GET['id'];

    $sqlSelect = "SELECT * FROM despesas WHERE id=$id";

    $result = $pdo->query($sqlSelect);

    if($result->num_rows > 0){
       
        $sqlDelete = "DELETE FROM despesas where id=$id";
        $resultDelete = $pdo->query($sqlDelete);    
        
    }      
}

header('Location: telaDespesa.php');


?>