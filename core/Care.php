<?php

// Class Name: Language

class Care{

  // Db Property
  private $db;

  // Db __construct Method
  public function __construct(){
    $this->db = new Database();
  }
  // Select lang
  public function Load_Care_from_db($id){

    $sql = "SELECT text as result FROM tbl_lang where id =:id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    while($row = $stmt->fetch()) {
        $data = $row['result'];
    }
    return $data;
  }
    // Get info about a planed check
    public function getCheckInfoById($careid){
      $sql = "SELECT * FROM tbl_care_type WHERE id = :id LIMIT 1";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $careid);
      $stmt->execute();
      $result = $stmt->fetch(PDO::FETCH_OBJ);
      if ($result) {
        return $result;
      }else{
        return false;
      }

    }

  // Get Single User Information By Id Method
  public function getCareInfoById($userid){
          $sql = "SELECT * FROM klient_care_list WHERE id = :id LIMIT 1";
          $stmt = $this->db->pdo->prepare($sql);
          $stmt->bindValue(':id', $userid);
          $stmt->execute();
          $result = $stmt->fetch(PDO::FETCH_OBJ);
          if ($result) {
            return $result;
          }else{
            return false;
          }
        }
  // Check if selected care is already in the list
  public function getCheckInfoIfCareExist($careid, $klientid){
   
    // Vyber time limit pre linku
    $sql = "SELECT * FROM tbl_klient WHERE id = :id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':id', $klientid);
    $stmt->execute();
    while($row = $stmt->fetch()) {
      $model_id = $row['model_id'];
      $time_1 = $row['Time_1'];
      $time_2 = $row['Time_2'];
      $line_id = $row['id'];
    }
    $today_start = date("Y-m-d").' 00:01:00';
    $today_end = date("Y-m-d").' 23:59:00';
    $current_time = date("H:i:s");
    if ($current_time > $time_1 && $current_time < $time_2) {
      $today_start = '00:00:00';
      $today_end = $time_2;
    }elseif ($current_time > $time_2) {
      $today_start = $time_1;
      $today_end = '24:00:00';
    }
    // Pocheckuj ci je uz nieco v liste
    $sql = "SELECT * FROM klient_care_list WHERE client_id = :line_id AND care_type = :care_type and care_time > :start and care_time < :end LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':care_type', $careid);
    $stmt->bindValue(':line_id', $klientid);
    $stmt->bindValue(':start', $today_start);
    $stmt->bindValue(':end', $today_end);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    if ($result) {
      
        return  'Hotovo';
      
    }else{
      return 'Naplánované';
    }
  }


  public function care_name($role){
          $sql = "SELECT * FROM tbl_care_type WHERE id = :roles LIMIT 1";
          $stmt = $this->db->pdo->prepare($sql);
          $stmt->bindValue(':roles', $role);
          $stmt->execute();
          while($row = $stmt->fetch()) {
            $data = $row['item'];
          }
          return $data;
  }

  
      
 

}
