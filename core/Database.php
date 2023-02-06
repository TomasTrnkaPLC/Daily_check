<?php

// Class Databse
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
class  Database{

  public $pdo;


  // Construct Class
  public function __construct(){

    if (!isset($this->pdo)) {
      try {
        $link = new PDO("sqlsrv:server=EUBISKDB03;Database=QA_Audit", "quality", "Qual1ty007");
        $link->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        $link->setAttribute(PDO::ATTR_STRINGIFY_FETCHES, false);
        $link->setAttribute(PDO::SQLSRV_ATTR_FETCHES_NUMERIC_TYPE, true); // Got Error  
        $link->setAttribute(PDO::SQLSRV_ATTR_ENCODING, PDO::SQLSRV_ENCODING_UTF8);
        $this->pdo  =  $link;
        
      } catch (PDOException $e) {
          die("Connection error...".$e->getMessage());
      }

    }


  }
}

