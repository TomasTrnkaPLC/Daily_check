<?php

include "Database.php";

require 'PHPmail/Exception.php';
require 'PHPmail/PHPMailer.php';
require 'PHPmail/SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
// create a new object
$mail = new PHPMailer();
// configure an SMTP
$mail->isSMTP();
$mail->Host = 'smtp.m1.websupport.sk';
$mail->SMTPAuth = true;
$mail->Username = 'upozornenie@albertspravca.sk';
$mail->Password = 'Qx7{Kx3+~N';
$mail->SMTPSecure = 'SSL/TLS';
$mail->Port = 465;

$mail->setFrom('upozornenie@albertspravca.sk', 'Albert Správca');
$mail->addAddress('tomas.trnka.plc@gmail.com', 'Me');
$mail->Subject = 'Thanks for choosing Our Hotel!';
// Set HTML 
$mail->isHTML(TRUE);
$mail->Body = '<html>Hi there, we are happy to <br>confirm your booking.</br> Please check the document in the attachment.</html>';
$mail->AltBody = 'Hi there, we are happy to confirm your booking. Please check the document in the attachment.';

// send the message
//if(!$mail->send()){
    echo 'Message could not be sent.';
    echo 'Mailer Error: ' . $mail->ErrorInfo;
//} else {
    echo 'Message has been sent';
//}
$dbc = new Database();

$today_start = date("Y-m-d").' 00:01:00';
$today_end = date("Y-m-d").' 23:59:00';

// Najprv povyberaj co bolo naplanovane na dnes a nie je to hotove
$userid = '19';
$sql = "SELECT * FROM tbl_klient WHERE id = :id";
$stmt = $dbc->pdo->prepare($sql);
$stmt->bindValue(':id', $userid);
$stmt->execute();
while($row = $stmt->fetch()) {
  $model_id = $row['model_id'];
  $time_1 = $row['Time_1'];
  $time_2 = $row['Time_2'];
  $line_id = $row['id'];
}
// Potom potahame item z tbl_care_type ak uz je blizko 14:00 tak sa zobrazi Time_2
$current_time = date("H:i:s");
if ($current_time > $time_1 && $current_time < $time_2) {
  $sql = "SELECT * FROM tbl_care_type WHERE ckeck_list_id = :id and aktivne = 1 Order by Position Asc  ";
}elseif ($current_time > $time_2) {
  $sql = "SELECT * FROM tbl_care_type WHERE ckeck_list_id = :id and aktivne = 1 Order by Position Asc  ";
}


$sql = "SELECT * FROM tbl_care_type WHERE ckeck_list_id = :id and aktivne = 1 Order by Position Asc  ";
$stmt = $dbc->pdo->prepare($sql);
$stmt->bindValue(':id', $model_id);
$stmt->execute();
$from_tbl_care_type = $stmt->fetchAll(PDO::FETCH_OBJ);
$id_position = 0;
foreach ($from_tbl_care_type as $row) {
   $current_time = date("H:i:s");
   $pozicia = $row->Position;
   $model_type = $row->ckeck_list_id;
   $revizia = $row->revizia;
   $time = date("Y-m-d").' '.'00:00:00';
   $time2 = date("Y-m-d").' '.'23:59:00';
   if ($current_time < $time_1 && $current_time < $time_2) {   
    $today_end = date("Y-m-d").' 23:59:00';
    $time = date("Y-m-d").' '.$time_1;
    $time2 = date("Y-m-d").' '.$time_2;
   
   }elseif ($current_time > $time_2) {
    $time = date("Y-m-d").' '.$time_2;
    $time2 = date("Y-m-d").' '.'23:59:00';

   }
  // Skontrolujeme status a sice ak neexistuje v klient_care_list tak ju zobrazime ako nevykonana

  $sql = "SELECT * FROM klient_care_list WHERE client_id = :klient_id and care_type = :care_id and end_time > :time and end_time < :time2";
  $stmt = $dbc->pdo->prepare($sql);
  $stmt->bindValue(':klient_id', $userid);
  $stmt->bindValue(':care_id', $row->id);
  $stmt->bindValue('time', $time);
  $stmt->bindValue('time2', $time2);

  $stmt->execute();
  $from_klient_care_list = $stmt->fetchAll(PDO::FETCH_OBJ);
  if ($from_klient_care_list) {
    foreach ($from_klient_care_list as $row2) {
      $status = 'Chyba';
    }
  }else{
    // Vloz do klient_care_list
        // Povyberaj udaje s tabulky ckeck_list 
        $sql = "SELECT * FROM ckeck_list WHERE id = :id";
        $stmt = $dbc->pdo->prepare($sql);
        $stmt->bindValue(':id', $model_type);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_OBJ);
        $seria = $result->name;
        // A vsetko pekne poukladaj do tabulky klient_care_list
        $sql = "INSERT INTO klient_care_list (client_id	, care_type, user_id, note, status, result_switch, revizia, model_name, Position ) VALUES(:client_id, :care_type, :user_id, :note, :status, :result_switch, :revizia, :model_name, :Position)";
        $stmt = $dbc->pdo->prepare($sql);
        $stmt->bindValue(':client_id', $line_id);
        $stmt->bindValue(':care_type', $row->id);
        $stmt->bindValue(':user_id', '999');
        $stmt->bindValue(':note', 'Nesplnená na čas');
        $stmt->bindValue(':status', 'Chyba');
        $stmt->bindValue(':result_switch', 'off');
        $stmt->bindValue(':revizia', $revizia);
        $stmt->bindValue(':model_name', $seria);
        $stmt->bindValue(':Position', $pozicia);
        $result = $stmt->execute();
  }
}



// Kalkulacia
$sql = "SELECT count(id) as total FROM klient_care_list WHERE care_time > :start and care_time < :end";
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
  $stmt->bindValue(':parameter', 'Celkovo dnes');
  $stmt->bindValue(':result', $data);

  $result = $stmt->execute();  


$sql = "SELECT count(id) as total FROM tbl_klient";
$stmt= $dbc->pdo->prepare($sql);
$stmt->execute();
while($row = $stmt->fetch()) {
    $data = $row['total'];
  }

  $sql = "UPDATE tbl_config SET
  value = :result
 
  WHERE parameter = :parameter ";
  $stmt= $dbc->pdo->prepare($sql);
  $stmt->bindValue(':parameter', 'Celkovo klientov');
  $stmt->bindValue(':result', $data);

  $result = $stmt->execute();  
  $today_start = date("Y-m-d").' 00:01:00';
  $date = strtotime($today_start);
  $today_start = strtotime("-7 day", $date);
  $today_end = date("Y-m-d").' 23:59:00';
  $sql = "SELECT count(id) as total FROM klient_care_list WHERE care_time > :start and care_time < :end and result_switch = 'on'";
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
    $stmt->bindValue(':parameter', 'Celkov tyzden uspesne');
    $stmt->bindValue(':result', $data);
  
    $result = $stmt->execute();  
    
    $today_start = date("Y-m-d").' 00:01:00';
    
    $today_start = strtotime("-7 day", $date);
    $today_end = date("Y-m-d").' 23:59:00';
    $sql = "SELECT count(id) as total FROM klient_care_list WHERE care_time > :start and care_time < :end and result_switch = 'off'";
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
  $stmt->bindValue(':parameter', 'Celkov tyzden neuspesne');
  $stmt->bindValue(':result', $data);

  $result = $stmt->execute();  



  $today_start = date("Y-m-d").' 00:01:00';
  
  $today_start = strtotime("-30 day", $date);
  $today_end = date("Y-m-d").' 23:59:00';
  $sql = "SELECT count(id) as total FROM klient_care_list WHERE care_time > :start and care_time < :end and result_switch = 'on'";
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
$stmt->bindValue(':parameter', 'Celkov mesiac uspesne');
$stmt->bindValue(':result', $data);

$result = $stmt->execute(); 




$today_start = date("Y-m-d").' 00:01:00';
  
$today_start = strtotime("-30 day", $date);
$today_end = date("Y-m-d").' 23:59:00';
$sql = "SELECT count(id) as total FROM klient_care_list WHERE care_time > :start and care_time < :end and result_switch = 'off'";
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
$stmt->bindValue(':parameter', 'Celkov mesiac neuspesne');
$stmt->bindValue(':result', $data);

$result = $stmt->execute(); 