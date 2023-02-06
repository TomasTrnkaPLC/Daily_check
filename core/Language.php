<?php

// Class Name: Language

class Language{

  // Db Property
  private $db;

  // Db __construct Method
  public function __construct(){
    $this->db = new Database();
  }
  // Select lang
  public function Load_Lang_from_db($id){

    $sql = "SELECT text as result FROM tbl_lang where id =:id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    while($row = $stmt->fetch()) {
        $data = $row['result'];
    }
    return $data;
  }






}
