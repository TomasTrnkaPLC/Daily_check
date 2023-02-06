<?php

include_once 'Session.php';


class Analytic{
  // Db Property
  private $db;

  // Db __construct Method
  public function __construct(){
    $this->db = new Database();
  }

  // Date formate Method
   public function formatDate($date){
      $strtime = strtotime($date);
    return date('Y-m-d H:i:s', $strtime);
   }


  public function today_counter(){
    $sql = "SELECT value as total FROM  tbl_config WHERE parameter = 'Celkov dnes uspesne'";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
  
    while($row = $stmt->fetch()) {
      $pass = $row['total'];
    }

    $sql = "SELECT value as total FROM  tbl_config WHERE parameter = 'Celkov dnes neuspesne'";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
  
    while($row = $stmt->fetch()) {
      $fail = $row['total'];
    }
    $data = $pass.' / '.$fail;

    return $data;
  }

  public function week_counter(){
    
    $sql = "SELECT value as total FROM  tbl_config WHERE parameter = 'Celkov tyzden uspesne'";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
  
    while($row = $stmt->fetch()) {
      $pass = $row['total'];
    }

    $sql = "SELECT value as total FROM  tbl_config WHERE parameter = 'Celkov tyzden neuspesne'";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
  
    while($row = $stmt->fetch()) {
      $fail = $row['total'];
    }
    $data = $pass.' / '.$fail;

    return $data;
  }
  public function month_counter(){
    
    $sql = "SELECT value as total FROM  tbl_config WHERE parameter = 'Celkov mesiac uspesne'";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
  
    while($row = $stmt->fetch()) {
      $pass = $row['total'];
    }

    $sql = "SELECT value as total FROM  tbl_config WHERE parameter = 'Celkov mesiac neuspesne'";
    $stmt = $this->db->pdo->prepare($sql);

    $stmt->execute();
  
    while($row = $stmt->fetch()) {
      $fail = $row['total'];
    }
    $data = $pass.' / '.$fail;

    return $data;
  }
}


