<?php

include "Database.php";

$dbc = new Database();

$today_start = date("Y-m-d").' 00:01:00';
$today_end = date("Y-m-d").' 23:59:00';
$sql = "SELECT count(id) as total FROM klient_care_list WHERE care_time > :start and care_time < :end and result_switch != NULL";
$stmt= $dbc->pdo->prepare($sql);
$stmt->bindValue(':start', $today_start);
$stmt->bindValue(':end', $today_end);
$stmt->execute();
while($row = $stmt->fetch()) {
    $data = $row['total'];
}

  $sql = "UPDATE tbl_config SET
  value = :result
 
  WHERE parameter = :parameter ";
  $stmt= $dbc->pdo->prepare($sql);
  $stmt->bindValue(':parameter', 'Celkovo hotovo');
  $stmt->bindValue(':result', $data);

  $result = $stmt->execute();  



  $sql = "SELECT count(id) as total FROM klient_care_list WHERE care_time > :start and care_time < :end and result_switch = 'on'";
  $stmt= $dbc->pdo->prepare($sql);
  $stmt->bindValue(':start', $today_start);
  $stmt->bindValue(':end', $today_end);
  $stmt->execute();  


  $sql = "UPDATE tbl_config SET
  value = :result
 
  WHERE parameter = :parameter ";
  $stmt= $dbc->pdo->prepare($sql);
  $stmt->bindValue(':parameter', 'Celkov dnes uspesne');
  $stmt->bindValue(':result', $data);

  $result = $stmt->execute();  

  $sql = "SELECT count(id) as total FROM klient_care_list WHERE care_time > :start and care_time < :end and result_switch = 'off'";
  $stmt= $dbc->pdo->prepare($sql);
  $stmt->bindValue(':start', $today_start);
  $stmt->bindValue(':end', $today_end);
  $stmt->execute();  


  $sql = "UPDATE tbl_config SET
  value = :result
 
  WHERE parameter = :parameter ";
  $stmt= $dbc->pdo->prepare($sql);
  $stmt->bindValue(':parameter', 'Celkov dnes neuspesne');
  $stmt->bindValue(':result', $data);

  $result = $stmt->execute();  

  //Update for activity after a certain care_time

$today_start = date("Y-m-d").' 00:01:00';
$today_end = date("Y-m-d").' 23:59:00';
$sql = "SELECT * FROM klient_care_list WHERE care_time > :start and care_time < :end and status = 'Naplánované'";
$stmt= $dbc->pdo->prepare($sql);
$stmt->bindValue(':start', $today_start);
$stmt->bindValue(':end', $today_end);
$stmt->execute();
while($row = $stmt->fetch()) {
    $id = $row['id'];
    $end_time = $row['end_time'];
    $care_time = strtotime($row['care_time']);
    $time_now = strtotime(date("Y-m-d H:i:s"));
    $time_diff = round(abs($time_now - $care_time) / 60,2);
    if ($time_diff > $end_time){
      $sql = "UPDATE klient_care_list SET  result_switch = :result_switch, note = :note, status = :status, user_id = :user_id  WHERE id = :id ";
      $stmts= $dbc->pdo->prepare($sql);
      $stmts->bindValue(':result_switch', 'off');
      $stmts->bindValue(':status', 'Chyba');
      $stmts->bindValue(':note', 'Nesplnená na čas');
      $stmts->bindValue(':id', $id);
      $stmt->bindValue(':user_id', '999');
      $results = $stmts->execute();  
    }
}
