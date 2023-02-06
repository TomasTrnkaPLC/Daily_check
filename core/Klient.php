<?php

include_once 'Session.php';


class Klient{


  // Db Property
  private $db;

  // Db __construct Method
  public function __construct(){
    $this->db = new Database();
  }

  // Date formate Method
   public function formatDate($date){
     // date_default_timezone_set('Asia/Dhaka');
      $strtime = strtotime($date);
    return date('Y-m-d H:i:s', $strtime);
   }

  // User Registration Method
  public function userRegistration($data){
    $name = $data['name'];
    $username = $data['username'];
    $email = $data['email'];
    $mobile = $data['mobile'];
    $roleid = $data['roleid'];
    $password = $data['password'];

    $checkEmail = $this->checkExistEmail($email);

    if ($name == "" || $username == "" || $email == "" || $mobile == "" || $password == "") {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
        <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
        <strong>Error !</strong> Please, User Registration field must not be Empty !</div>';
        return $msg;
    }elseif (strlen($username) < 3) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
        <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
        <strong>Error !</strong> Username is too short, at least 3 Characters !</div>';
        return $msg;
    }elseif (filter_var($mobile,FILTER_SANITIZE_NUMBER_INT) == FALSE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
        <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
        <strong>Error !</strong> Enter only Number Characters for Mobile number field !</div>';
        return $msg;

    }elseif(strlen($password) < 5) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
        <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
        <strong>Error !</strong> Password at least 6 Characters !</div>';
        return $msg;
    }elseif(!preg_match("#[0-9]+#",$password)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
        <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
        <strong>Error !</strong> Your Password Must Contain At Least 1 Number !</div>';
        return $msg;
    }elseif(!preg_match("#[a-z]+#",$password)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
        <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
        <strong>Error !</strong> Your Password Must Contain At Least 1 Number !</div>';
        return $msg;
    }elseif (filter_var($email, FILTER_VALIDATE_EMAIL === FALSE)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
        <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
        <strong>Error !</strong> Invalid email address !</div>';
        return $msg;
    }elseif ($checkEmail == TRUE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
        <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
        <strong>Error !</strong> Email already Exists, please try another Email... !</div>';
        return $msg;
    }else{

      $sql = "INSERT INTO tbl_users(name, username, email, password, mobile, roleid) VALUES(:name, :username, :email, :password, :mobile, :roleid)";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':name', $name);
      $stmt->bindValue(':username', $username);
      $stmt->bindValue(':email', $email);
      $stmt->bindValue(':password', SHA1($password));
      $stmt->bindValue(':mobile', $mobile);
      $stmt->bindValue(':roleid', $roleid);
      $result = $stmt->execute();
      if ($result) {
        $msg = '<div class="alert alert-Hotovo alert-dismissible mt-3" id="flash-msg">
        <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
        <strong>Hotovo !</strong> Wow, you have Registered  !</div>';
          return $msg;
      }else{
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg">
        <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
        <strong>Error !</strong> Something went Wrong !</div>';
          return $msg;
      }
    }
  }

  public function updatecareforklient($data){
    $care_done = date("Y-m-d H:i:s");
    $status = 'Hotovo';     
    $id = $data['id'];
    $user_id = $data['user_id'];
    $result_switch = $data['result_switch']; 
    $line_id = $data['line_id'];
    $Position = $data['position'];
    $note = $data['note'];
    // Povyberaj udaje s tabulky tbl_care_type
    $sql = "SELECT * FROM tbl_care_type WHERE id = :id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    $item = $result->item;
    $link = $result->link;
    $revizia = $result->revizia;
    $pozicia = $result->Position;
    $model_type = $result->ckeck_list_id;

    // Povyberaj udaje s tabulky ckeck_list 
    $sql = "SELECT * FROM ckeck_list WHERE id = :id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':id', $model_type);
    $stmt->execute();
    $result = $stmt->fetch(PDO::FETCH_OBJ);
    $seria = $result->name;
    // A vsetko pekne poukladaj do tabulky klient_care_list
    $sql = "INSERT INTO klient_care_list (client_id	, care_type, user_id, note, status, result_switch, revizia, model_name, Position ) VALUES(:client_id, :care_type, :user_id, :note, :status, :result_switch, :revizia, :model_name, :Position)";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':client_id', $line_id);
    $stmt->bindValue(':care_type', $id);
    $stmt->bindValue(':user_id', $user_id);
    $stmt->bindValue(':note', $note);
    $stmt->bindValue(':status', $status);
    $stmt->bindValue(':result_switch', $result_switch);
    $stmt->bindValue(':revizia', $revizia);
    $stmt->bindValue(':model_name', $seria);
    $stmt->bindValue(':Position', $pozicia);
    $result = $stmt->execute();


  if ($result) {
    
    Session::set('msg', '<div class="alert alert-Hotovo alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: greenyellow;">
    <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
    <strong>Hotovo !</strong> Úspešne aktualizované !</div>
    ');

  }else{
    $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
      <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
      <strong>Error !</strong> Ups niečo je zle !</div>';
      return $msg;
  }
    }


    
 // Return control list asigned to model
    public function selectAllPlanForModel($id){
      $sql = "SELECT * FROM tbl_care_type WHERE ckeck_list_id = :id and aktivne = '1' Order by Position ASC";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
      return $stmt->fetchAll(PDO::FETCH_OBJ);
    }
  // Return control list asigned to model
    public function selectModelCheckNameById($id){
      $sql = "SELECT * FROM ckeck_list WHERE id = :id ";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $id);
      $stmt->execute();
      while($row = $stmt->fetch()) {
        $name = $row['name'];   
      }
      $data = $name;
      return $data;
    }
  public function addNewUserByAdmin($data){
    $meno = $data['meno'];
    $model = $data['model'];

    $sql = "SELECT * FROM  ckeck_list WHERE id = :model";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':model', $model);
 
    $stmt->execute();
    $name = 'Ne je';
    while($row = $stmt->fetch()) {
      $name = $row['name'];
    }
    $sql = "INSERT INTO tbl_klient (meno, model, model_id ) VALUES(:meno, :model, :model_id)";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':meno', $meno);
    $stmt->bindValue(':model', $name);
    $stmt->bindValue(':model_id', $model);
   

    $result = $stmt->execute();
      if ($result) {
        $msg = '<div class="alert alert-Hotovo alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: greenyellow;">
          <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
          <strong>Hotovo !</strong> Pridanie zariadenia úspešné !</div>
          <meta http-equiv="Refresh" content="2" url="../../client_list.php"" />';
          return $msg;
      }else{
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
          <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
          <strong>Error !</strong> Ups.. Niečo je zle!</div>';
          return $msg;
      }
    }

  public function total_task_counter(){


    $sql = "SELECT value as total FROM  tbl_config WHERE parameter = 'Celkovo dnes'";
    $stmt = $this->db->pdo->prepare($sql);

    $stmt->execute();
  
    while($row = $stmt->fetch()) {
      $data = $row['total'];
    }
    return $data;
  }

  public function total_task_counter_done(){

    $sql = "SELECT value as total FROM  tbl_config WHERE parameter = 'Celkovo hotovo'";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
  
    while($row = $stmt->fetch()) {
      $data = $row['total'];
    }
    return $data;
  }

  public function total_client_counter(){
    $sql = "SELECT value as total FROM  tbl_config WHERE parameter = 'Celkovo klientov'";
    $stmt = $this->db->pdo->prepare($sql);

    $stmt->execute();
  
    while($row = $stmt->fetch()) {
      $data = $row['total'];
    }
    return $data;
  }

  public function deletecaretype($data){
    $id = $data['id'];
    $sql = "DELETE tbl_care_type WHERE id = :id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $result = $stmt->execute();
    if ($result) {
      return true;
    }else{
      return false;
    }
}

  public function addcaretype($data){
        $item = $data['item'];
        $note = $data['note'];
        $link = $data['link'];
        $series = $data['series'];
        $editor= $_SESSION['id'];
        $sql = "SELECT max(Position) as total FROM  tbl_care_type WHERE ckeck_list_id = :series and aktivne = 1";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindValue(':series', $series);
     
        $stmt->execute();
      
        while($row = $stmt->fetch()) {
          $data = $row['total'];
        }
        $position = 1 + intval($data);
    
        $sql = "INSERT INTO tbl_care_type (item, note, link, ckeck_list_id, revizia, aktivne, position) VALUES(:item,:note,:link, :series, 0 , '1', '$position')";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindValue(':item', $item);
        $stmt->bindValue(':note', $note);
        $stmt->bindValue(':link', $link);
        $stmt->bindValue(':series', $series);
       
        $result = $stmt->execute();
          if ($result) {
            $msg = '<div class="alert alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: greenyellow;">
                <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
                <strong>Hotovo !</strong> Úspešne naplánované !</div>
                <meta http-equiv="Refresh" content="2" url="../../client_list.php"" />';
              return $msg;
          }else{
            $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
              <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
              <strong>Chyba !</strong> Ups.. Niečo je zle!</div>';
              return $msg;
          }
    }

    public function addcaretypetoklient($data){
      $care_type = $data['care_type'];
      $client_id = $data['client_id'];
      $status = $data['status'];
  
      $sql = "INSERT INTO klient_care_list (care_type, client_id, care_time, status) VALUES(:care_type,:client_id,:care_time,:status)";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':care_type', $care_type);
      $stmt->bindValue(':client_id', $client_id);
      $stmt->bindValue(':care_time', $care_time);
      $stmt->bindValue(':status', $status);
    
      $result = $stmt->execute();
        if ($result) {
          $msg = '<div class="alert alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: greenyellow;">
              <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
              <strong>Hotovo !</strong> Úspešne naplánované !</div>
              <meta http-equiv="Refresh" content="2" url="../../client_list.php"" />';
            return $msg;
        }else{
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
              <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
              <strong>Chyba !</strong> Ups.. Niečo je zle!</div>';
            return $msg;
        }
  }


  public function addcklinetcaretype($data){
    $client_id = $data['client_id'];
    $care_type = $data['sel_care'];
    $note = $data['note'];
    $status = 'Naplánované';
    $care_time = $data['care_time'];
    $end_time = $data['end_limit'];
    if ( empty($data['care_repeat']) ) {
      $care_repeat = 'Óff';
    }else{
      $care_repeat = $data['care_repeat'];
    }
    if ( empty($data['care_repeat_week']) ) {
      $care_repeat_week = 'Óff';
    }else{
      $care_repeat_week = $data['care_repeat_week'];
    }
    if ( empty($data['care_repeat_day']) ) {
      $care_repeat_day = 'Óff';
    }else{
      $care_repeat_day = $data['care_repeat_day'];
    }
    if ( empty($data['care_repeat_time']) ) {
      $care_repeat_time = 0;
    }
    $care_repeat_time = $data['care_repeat_time'];

    
    if ($care_repeat_week == 'On' or $care_repeat_day == 'On' ) {
      if ($care_repeat_week == 'On') {
        $total = 0;
        echo 'Week On';
        while (1){
         
          $sql = "INSERT INTO klient_care_list (client_id, care_type, note, status, care_time, end_time) VALUES(:client_id,:care_type,:note, :status, :care_time, :end_time)";
         
          $stmt = $this->db->pdo->prepare($sql);
          $stmt->bindValue(':client_id', $client_id);
          $stmt->bindValue(':care_type', $care_type);
          $stmt->bindValue(':note', $note);
          $stmt->bindValue(':status', $status);
          $stmt->bindValue(':care_time', $care_time);
          $stmt->bindValue(':end_time', $end_time);
          $result = $stmt->execute();
          $care_time = date('Y-m-d H:i:s', strtotime($care_time . ' +7 day'));
        
          $total = $total + 1;
          if ($total == intval($care_repeat_time)){
            $msg = '<div class="alert alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: greenyellow;">
            <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
            <strong>Hotovo !</strong> Kontrola naplánovná !</div>';
            break;
          }
        }

      }elseif($care_repeat_day == 'On'){
        $total = 0;
        echo 'Day On';
        echo $care_repeat_time;
        while (1){
          $sql = "INSERT INTO klient_care_list (client_id, care_type, note, status, care_time) VALUES(:client_id,:care_type,:note, :status, :care_time)";
          $stmt = $this->db->pdo->prepare($sql);
          $stmt->bindValue(':client_id', $client_id);
          $stmt->bindValue(':care_type', $care_type);
          $stmt->bindValue(':note', $note);
          $stmt->bindValue(':status', $status);
          $stmt->bindValue(':care_time', $care_time);
          echo "Datas";
          $result = $stmt->execute();
          $care_time = date('Y-m-d H:i:s', strtotime($care_time . ' +1 day'));
        
          $total = $total + 1;
          if ($total == intval($care_repeat_time)){
            $msg = '<div class="alert alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: greenyellow;">
            <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
            <strong>Hotovo !</strong> Úspešne naplánované !</div>
            <meta http-equiv="Refresh" content="2" url="../../client_list.php"" />';
            break;
          }
        }
      }

    }else{
      $sql = "INSERT INTO klient_care_list (client_id, care_type, note, status, care_time) VALUES(:client_id,:care_type,:note, :status, :care_time)";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':client_id', $client_id);
      $stmt->bindValue(':care_type', $care_type);
      $stmt->bindValue(':note', $note);
      $stmt->bindValue(':status', $status);
      $stmt->bindValue(':care_time', $care_time);
      $result = $stmt->execute();
    
      if ($result != '') {
        $msg = '<div class="alert alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: greenyellow;">
          <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
          <strong>Hotovo !</strong> Úspešne naplánované !</div>
          <meta http-equiv="Refresh" content="2" url="../../client_list.php"" />';
      }else{
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
          <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
          <strong>Chyba !</strong> Ups.. Niečo je zle!</div>';
      }
    }
      return $msg;
}


  
  // Select All care
  public function selectAllCare(){
    $sql = "SELECT * FROM tbl_care_type where aktivne = 1 ORDER BY id DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }


  // Select Role
  public function care_name($role){
    $sql = "SELECT * FROM tbl_care_type WHERE id = :roles and aktivne = 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':roles', $role);
    $stmt->execute();
    while($row = $stmt->fetch()) {
      $data = $row['item'];
    }
    return $data;
    }

      // Select Role
  public function care_name_description($role){
    $sql = "SELECT * FROM tbl_care_type WHERE id = :roles LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':roles', $role);
    $stmt->execute();
    while($row = $stmt->fetch()) {
      $data = $row['link'];
    }
    return $data;
    }
// Select Role
  public function selectRole($role){
  $sql = "SELECT *FROM tbl_roles WHERE id = :roles LIMIT 1";
  $stmt = $this->db->pdo->prepare($sql);
  $stmt->bindValue(':roles', $role);
  $stmt->execute();
  while($row = $stmt->fetch()) {
    $data = $row['role'];
  }
  return $data;
  }
 //Select Client name
 
 public function selectClientName($role){
  $sql = "SELECT *FROM tbl_klient WHERE id = :roles LIMIT 1";
  $stmt = $this->db->pdo->prepare($sql);
  $stmt->bindValue(':roles', $role);
  $stmt->execute();
  while($row = $stmt->fetch()) {
    $meno = $row['meno'];
    $priezvisko = $row['priezvisko'];
  }
  $data = $meno.' '.$priezvisko;
  return $data;
  }

  public function selectAllcareForKlient($role){
    $sql = "SELECT * FROM klient_care_list WHERE client_id = :roles ORDER BY care_time DESC";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':roles', $role);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  // Select All User Method
  public function selectAllModelData(){
    $sql = "SELECT * FROM ckeck_list ORDER BY name asc";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  // Select All User Method
  public function selectAllUserData(){
    $sql = "SELECT * FROM tbl_klient ORDER BY id Asc";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

    // Select All User Plan for today
  public function SelectAllUserPlanToday(){
    $today_start = date("Y-m-d").' 00:01:00';
    $today_end = date("Y-m-d").' 23:59:00';
    $sql = "SELECT * FROM klient_care_list WHERE care_time > :start and care_time < :end";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':start', $today_start);
    $stmt->bindValue(':end', $today_end);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }

  // Return client name
  public function selectClientNameById($id){
    $sql = "SELECT * FROM tbl_klient WHERE id = :id";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':id', $id);
    $stmt->execute();
    while($row = $stmt->fetch()) {
      $meno = $row['meno'];
      $priezvisko = $row['priezvisko'];
    }
    $data = $meno.' '.$priezvisko;
    return $data;
  }

 // Return care name
 public function SelectCareNameById($id){
  $sql = "SELECT * FROM tbl_care_type WHERE id = :id";
  $stmt = $this->db->pdo->prepare($sql);
  $stmt->bindValue(':id', $id);
  $stmt->execute();
  while($row = $stmt->fetch()) {
    $item = $row['item'];
  }
  return $item;
}

  // User login Autho Method
  public function userLoginAutho($email, $password){
    $password = SHA1($password);
    $sql = "SELECT * FROM tbl_users WHERE email = :email and password = :password LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }
  // Check User Account Satatus
  public function CheckActiveUser($email){
    $sql = "SELECT * FROM tbl_users WHERE email = :email and isActive = :isActive LIMIT 1";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':isActive', 1);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }





    // Get Single User Information By Id Method
    public function getUserInfoById($userid){
      $sql = "SELECT * FROM tbl_klient WHERE id = :id LIMIT 1";
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
    public function getCareInfoByIdEdit($userid){
          $sql = "SELECT * FROM tbl_care_type WHERE id = :id LIMIT 1";
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
    // Get Single User Information By Id Method
    public function getCareInfoByKlient($userid){
              $sql = "SELECT * FROM tbl_care_type WHERE id = :id LIMIT 1";
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
    
    public function selecShortClientHistory($userid){
              // Najprv potahajme Model_ID , Time_1 a Time_2 s tbl_blient
              
              $sql = "SELECT * FROM klient_care_list WHERE client_id = :id Limit 50";
              $stmt = $this->db->pdo->prepare($sql);
              $stmt->bindValue(':id', $userid);
              $stmt->execute();
              $result = $stmt->fetchAll(PDO::FETCH_OBJ);
              return $result;
            }
    
    public function selecLongClientHistory($userid){
              // Najprv potahajme Model_ID , Time_1 a Time_2 s tbl_blient
              
              $sql = "SELECT * FROM klient_care_list WHERE client_id = :id ";
              $stmt = $this->db->pdo->prepare($sql);
              $stmt->bindValue(':id', $userid);
              $stmt->execute();
              $result = $stmt->fetchAll(PDO::FETCH_OBJ);
              return $result;
            }        
            
    public function select_care_for_today($userid){
            // Najprv potahajme Model_ID , Time_1 a Time_2 s tbl_blient
            $today_start = date("Y-m-d").' 00:01:00';
            $today_end = date("Y-m-d").' 23:59:00';
            $sql = "SELECT * FROM tbl_klient WHERE id = :id";
            $stmt = $this->db->pdo->prepare($sql);
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
            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindValue(':id', $model_id);
            $stmt->execute();
            $from_tbl_care_type = $stmt->fetchAll(PDO::FETCH_OBJ);
            $result=array();
         
            $id_position = 0;
            foreach ($from_tbl_care_type as $row) {
               $current_time = date("H:i:s");
               if ($current_time > $time_1 && $current_time < $time_2) {
                $time = $time_1;
               }elseif ($current_time > $time_2) {
                $time = $time_2;
               }else{
                $time = $time_1;
               }
              // Skontrolujeme status a sice ak neexistuje v klient_care_list tak ju zobrazime ako nevykonana
              $sql = "SELECT * FROM klient_care_list WHERE client_id = :klient_id and care_type = :care_id ";
              $stmt = $this->db->pdo->prepare($sql);
              $stmt->bindValue(':klient_id', $userid);
              $stmt->bindValue(':care_id', $row->id);
      
              $stmt->execute();
              $from_klient_care_list = $stmt->fetchAll(PDO::FETCH_OBJ);
              if ($from_klient_care_list) {
                foreach ($from_klient_care_list as $row2) {
                  $status = 'Hotovo';
                }
              }else{
                $status = 'Naplánované';
              }
              //add elements/values in array
              array_push($result, ['id' => $row->id, 'item' => $row->item, 'link' => $row->link, 'position' => $row->Position, 'time' => $time, 'status' => $status, 'line_id' => $line_id]);
             
                $id_position = $id_position + 1;
        }
         //  var_dump($result);
            if ($result) {
              return $result;
            }else{
              return false;
            }
          }


    public function Model_toName($userid){
          
        $sql = "SELECT name FROM ckeck_list WHERE id = :id ";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->bindValue(':id', $userid);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_OBJ);
        $result = strval($result[0]->name);
        return $result;
      }      
    public function select_care_for_all($userid){
      $today_start = date("Y-m-d").' 00:01:00';
      $today_end = date("Y-m-d").' 23:59:00';
            $sql = "SELECT * FROM tbl_care_type WHERE ckeck_list_id = :id";
            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindValue(':id', $userid);
        
            $stmt->execute();
            $result = $stmt->fetchAll(PDO::FETCH_OBJ);
            if ($result) {
              return $result;
            }else{
              return false;
            }
          }      
  //
  //   Get Single User Information By Id Method
    public function updateUserByIdInfo($userid, $data){
      $name = $data['name'];
      $username = $data['username'];
      $email = $data['email'];
      $mobile = $data['mobile'];
      $roleid = $data['roleid'];



      if ($name == "" || $username == ""|| $email == "" || $mobile == ""  ) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20;">
  <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
  <strong>Error !</strong> Polia nesmú byť prázdne !</div>';
          return $msg;
        }elseif (strlen($username) < 3) {
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20;">
    <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
    <strong>Error !</strong> Meno je krátke. Aspoň 3 písmená !</div>';
            return $msg;
        }elseif (filter_var($mobile,FILTER_SANITIZE_NUMBER_INT) == FALSE) {
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20;">
    <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
    <strong>Error !</strong> Len čísla!</div>';
            return $msg;


      }elseif (filter_var($email, FILTER_VALIDATE_EMAIL === FALSE)) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20;">
  <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
  <strong>Error !</strong> Zlá emailová adresa!</div>';
          return $msg;
      }else{

        $sql = "UPDATE tbl_users SET
          name = :name,
          username = :username,
          email = :email,
          mobile = :mobile,
          roleid = :roleid
          WHERE id = :id";
          $stmt= $this->db->pdo->prepare($sql);
          $stmt->bindValue(':name', $name);
          $stmt->bindValue(':username', $username);
          $stmt->bindValue(':email', $email);
          $stmt->bindValue(':mobile', $mobile);
          $stmt->bindValue(':roleid', $roleid);
          $stmt->bindValue(':id', $userid);
        $result =   $stmt->execute();

        if ($result) {
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', '<div class="alert alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: greenyellow;">
          <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
          <strong>Hotovo !</strong> Aktualizácia úspešná!</div>');



        }else{
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20;">
    <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
    <strong>Error !</strong> Ups. Niečo je zle !</div>');


        }


      }


    }
    
    // Select All care
       public function selectAllSeries(){
        $sql = "SELECT * FROM ckeck_list where status = 1 ORDER BY id DESC";
        $stmt = $this->db->pdo->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function updateLineByIdInfo($userid, $data){
      $Time_1 = $data['Time_1'];
      $Time_2 = $data['Time_2'];
     
              $sql = "UPDATE tbl_klient SET
              Time_1 = :Time_1,
              Time_2 = :Time_2
              WHERE id = :id";
              $stmt= $this->db->pdo->prepare($sql);
              $stmt->bindValue(':Time_1', $Time_1);
              $stmt->bindValue(':Time_2', $Time_2);
              $stmt->bindValue(':id', $userid);
            $result =   $stmt->execute();

            if ($result) {
              echo "<script>location.href='index.php';</script>";
              Session::set('msg', '<div class="alert alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: greenyellow;">
              <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
              <strong>Hotovo !</strong> Aktualizácia úspešná!</div>');



            }else{
              echo "<script>location.href='index.php';</script>";
              Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20;">
        <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
        <strong>Error !</strong> Ups. Niečo je zle !</div>');


    }
  }

      




    public function updatecareByIdInfo($userid, $data){
      $item = $data['item'];
      $series = $data['series'];
      $link = $data['link'];
   
      $editor= $_SESSION['id'];
      $sql = "SELECT * FROM tbl_care_type WHERE id = :id";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $userid);
   
      $stmt->execute();
    
      while($row = $stmt->fetch()) {
        $revizia = $row['revizia'];
        $id_old = $row['id'];
        $Pozicial_old = $row['Position'];
        $model_old = $row['ckeck_list_id'];

      }
      $revizia = $revizia + 1;
      

          $sql = "UPDATE tbl_care_type SET
          aktivne = 0,
          editor = :editor
          WHERE id = :id";
          $stmt= $this->db->pdo->prepare($sql);
          $stmt->bindValue(':id', $userid);
          $stmt->bindValue(':editor', $editor);

          $data =   $stmt->execute();
          #Vyber max Poziciu pre seriu 
          $sql = "SELECT max(Position) as total FROM  tbl_care_type WHERE ckeck_list_id = :series and aktivne = 1";
          $stmt = $this->db->pdo->prepare($sql);
          $stmt->bindValue(':series', $series);
       
          $stmt->execute();
        
          while($row = $stmt->fetch()) {
            $data = $row['total'];
          }
          $position = 1 + intval($data);
        
     
          #Ak sa zmenil model tak zmen poziciu ak nie tak nechaj povodnu
          if (strval($model_old) == strval($series)) {
            $position = $Pozicial_old;
          }

          $sql = "INSERT INTO tbl_care_type (item, ckeck_list_id, link, revizia, aktivne, editor, Position) VALUES(:item,:series,:link, :revizia , 1, :editor, :Position)";
          $stmt = $this->db->pdo->prepare($sql);
          $stmt->bindValue(':item', $item);
          $stmt->bindValue(':series', $series);
          $stmt->bindValue(':link', $link);   
          $stmt->bindValue(':revizia', $revizia); 
          $stmt->bindValue(':editor', $editor);
          $stmt->bindValue(':Position', $position);
          $data = $stmt->execute();
          
          $sql = "SELECT * FROM tbl_care_type WHERE item = :item and aktivne = 1 ";
          $stmt = $this->db->pdo->prepare($sql);
          $stmt->bindValue(':item', $item);
          $stmt->execute();
             while($row = $stmt->fetch()) {
               $id_update = $row['id'];
           }
     
           
           $result =   $stmt->execute();

        if ($result) {
         echo "<script>location.href='care_list.php';</script>";
          Session::set('msg', '<div class="alert alert-Hotovo alert-dismissible mt-3" id="flash-msg" style=" z-index: 20;">
                <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
                <strong>Hotovo !</strong> Aktualizácia úspešná!'.$model_old.'.new.'.$series.'</div>');



        }else{
          echo "<script>location.href='care_list.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20;">
              <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
              <strong>Error !</strong> Ups. Niečo je zle !</div>');


        


      }




    }


   













}
