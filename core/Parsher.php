<?php

include "Database.php";
include_once "Session.php";

$dbc = new Database();

//Generate a function to check if posted variable is empty
if(!empty($_POST['deletecaretype'])){
      

      $id = $_POST['deletecaretype'];

      $sql = "DELETE FROM klient_care_list WHERE id = :id";
      $stmt= $dbc->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
   
      if ($stmt->execute()) {
        echo "Úspešne zmazané";
      
      }else{
        echo "Niekde je chyba";
 
      }


      
      return $id;
}



