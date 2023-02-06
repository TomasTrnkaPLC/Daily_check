<?php

include 'Database.php';
include_once 'Session.php';


class Users{


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



  // Check Exist Email Address Method
  public function checkExistEmail($email){
    $sql = "SELECT email from  tbl_users WHERE email = :email";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->execute();
    $result = $stmt->fetchall(); 
    if (count($result)> 0) {
      return true;
    }else{
      return false;
    }
  }

  // Add New User By Admin
  public function addNewUserByAdmin($data){
    $name = $data['name'];
    $username = $data['username'];
    $email = $data['email'];
    $mobile = $data['mobile'];
    $roleid = $data['roleid'];
    $password = $data['password'];

    $checkEmail = $this->checkExistEmail($email);

    if ($name == "" || $username == "" || $email == "" || $mobile == "" || $password == "") {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
<button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
<strong>Error !</strong> Polia nesmú byť prázdnbe!</div>';
        return $msg;
    }elseif (strlen($username) < 3) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
<button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
<strong>Error !</strong> Meno je krátke minimálne 3 písmená</div>';
        return $msg;
    }elseif (filter_var($mobile,FILTER_SANITIZE_NUMBER_INT) == FALSE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
<button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
<strong>Error !</strong> Kontakt musí obsahovať len písmená!</div>';
        return $msg;

    }elseif(strlen($password) < 5) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
<button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
<strong>Error !</strong> Heslo musí mať aspoň 6 znakov !</div>';
        return $msg;
    }elseif(!preg_match("#[0-9]+#",$password)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
<button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
<strong>Error !</strong> Heslo musí obsahovať aspoň 1 číslo !</div>';
        return $msg;
   
    }elseif (filter_var($email, FILTER_VALIDATE_EMAIL === FALSE)) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
<button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
<strong>Error !</strong> Zlá mailová adresa!</div>';
        return $msg;
    }elseif ($checkEmail == TRUE) {
      $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
<button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
<strong>Error !</strong> Email už existuje... !</div>';
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
        $msg = '<div class="alert alert-Hotovo alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: greenyellow;">
  <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
  <strong>Hotovo !</strong> Registrácia úspešná !</div>';
          return $msg;
      }else{
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
  <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
  <strong>Chyba !</strong> Ups.. Niečo je zle!</div>';
          return $msg;
      }



    }





  }

// Select Role
  public function selectRole($role){
  $sql = "SELECT * FROM tbl_roles WHERE id = :roles ";
  $stmt = $this->db->pdo->prepare($sql);
  $stmt->bindValue(':roles', $role);
  $stmt->execute();
  while($row = $stmt->fetch()) {
    $data = $row['role'];
  }
  return $data;

}
//Select Full name
public function selectfullname($role){
  $sql = "SELECT * FROM tbl_users WHERE id = :roles "; 
  $stmt = $this->db->pdo->prepare($sql);
  $stmt->bindValue(':roles', $role);
  $stmt->execute();
  while($row = $stmt->fetch()) {
    $name= $row['name'];
    $last_name = $row['username'];
  }
  $data = $name .' '. $last_name;
  return $data;

}


  // Select All User Method
  public function selectAllUserData(){
    $sql = "SELECT * FROM tbl_users where id != '999' ORDER BY id DESC  ";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_OBJ);
  }


  // User login Autho Method
  public function userLoginAutho($email, $password){
    $password = SHA1($password);
    $sql = "SELECT * FROM tbl_users WHERE email = :email and password = :password ";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':password', $password);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }
  // Check User Account Satatus
  public function CheckActiveUser($email){
    $sql = "SELECT * FROM tbl_users WHERE email = :email and isActive = :isActive ";
    $stmt = $this->db->pdo->prepare($sql);
    $stmt->bindValue(':email', $email);
    $stmt->bindValue(':isActive', 1);
    $stmt->execute();
    return $stmt->fetch(PDO::FETCH_OBJ);
  }




    // User Login Authotication Method
    public function userLoginAuthotication($data){
      $email = $data['email'];
      $password = $data['password'];

      
      $checkEmail = $this->checkExistEmail($email);

      if ($email == "" || $password == "" ) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
  <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
  <strong>Error !</strong> Email alebo heslo musia byt vyplnené!</div>';
          return $msg;

      
      }elseif ($checkEmail == FALSE) {
     
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
  <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
  <strong>Error !</strong> Žiadna emailova adresa sa nenašla!</div>';
          return $msg;
      }else{


        $logResult = $this->userLoginAutho($email, $password);
        $chkActive = $this->CheckActiveUser($email);

        if ($chkActive == TRUE) {
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
    <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
    <strong>Chyba !</strong> Váš účet bol deaktivovaný!</div>';
            return $msg;
        }elseif ($logResult) {

          Session::init();
          Session::set('login', TRUE);
          Session::set('id', $logResult->id);
          Session::set('roleid', $logResult->roleid);
          Session::set('name', $logResult->name);
          Session::set('email', $logResult->email);
          Session::set('username', $logResult->username);
          Session::set('logMsg', '<div class="alert alert-Hotovo alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: greenyellow;">
    <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
    <strong>Hotovo !</strong> Prihlásenie úspešné !</div>');
          echo "<script>location.href='index.php';</script>";

        }else{
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
    <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
    <strong>Chyba !</strong> Email alebo heslo nie je platné !</div>';
            return $msg;
        }

      }


    }



    // Get Single User Information By Id Method
    public function getUserInfoById($userid){
      $sql = "SELECT * FROM tbl_users WHERE id = :id ";
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

    // Check production mode
    public function Production_mode(){
      $sql = "SELECT * FROM tbl_config WHERE parameter = 'production' ";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->execute();
      while($row = $stmt->fetch()) {
        $data = $row['value'];
      }
      return $data;
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
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
  <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
  <strong>Error !</strong> Polia nesmú byť prázdne !</div>';
          return $msg;
        }elseif (strlen($username) < 3) {
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
    <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
    <strong>Error !</strong> Meno je krátke. Aspoň 3 písmená !</div>';
            return $msg;
        }elseif (filter_var($mobile,FILTER_SANITIZE_NUMBER_INT) == FALSE) {
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
    <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
    <strong>Error !</strong> Len čísla!</div>';
            return $msg;


      }elseif (filter_var($email, FILTER_VALIDATE_EMAIL === FALSE)) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
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
          Session::set('msg', '<div class="alert alert-Hotovo alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: greenyellow;">
          <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
          <strong>Hotovo !</strong> Aktualizácia úspešná!</div>');



        }else{
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
    <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
    <strong>Error !</strong> Ups. Niečo je zle !</div>');


        }


      }


    }




    // Delete User by Id Method
    public function deleteUserById($remove){
      $sql = "DELETE FROM tbl_users WHERE id = :id ";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':id', $remove);
        $result =$stmt->execute();
        if ($result) {
          $msg = '<div class="alert alert-Hotovo alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: greenyellow;">
    <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
    <strong>Hotovo !</strong> Zamestnanec je fuč !</div>';
            return $msg;
        }else{
          $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
    <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
    <strong>Error !</strong> Ups. Niečo je zle !</div>';
            return $msg;
        }
    }

    // User Deactivated By Admin
    public function userDeactiveByAdmin($deactive){
      $sql = "UPDATE tbl_users SET

       isActive=:isActive
       WHERE id = :id";

       $stmt = $this->db->pdo->prepare($sql);
       $stmt->bindValue(':isActive', 1);
       $stmt->bindValue(':id', $deactive);
       $result =   $stmt->execute();
        if ($result) {
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', '<div class="alert alert-Hotovo alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: greenyellow; ">
          <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
          <strong>Hotovo !</strong> Užívaťel bol deaktivovaný !</div>');

        }else{
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
    <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
    <strong>Chyba !</strong> DUpss niečo sa pokazilo !</div>');

            return $msg;
        }
    }


    // User Deactivated By Admin
    public function userActiveByAdmin($active){
      $sql = "UPDATE tbl_users SET
       isActive=:isActive
       WHERE id = :id";

       $stmt = $this->db->pdo->prepare($sql);
       $stmt->bindValue(':isActive', 0);
       $stmt->bindValue(':id', $active);
       $result =   $stmt->execute();
        if ($result) {
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', '<div class="alert alert-Hotovo alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: greenyellow;">
          <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
          <strong>Hotovo !</strong> Užívaťel bol deaktivovaný !</div>');
        }else{
          echo "<script>location.href='index.php';</script>";
          Session::set('msg', '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
    <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
    <strong>Chyba !</strong> Upss niečo sa pokazilo !</div>');

        }
    }




    // Check Old password method
    public function CheckOldPassword($userid, $old_pass){
      $old_pass = SHA1($old_pass);
      $sql = "SELECT password FROM tbl_users WHERE password = :password AND id =:id";
      $stmt = $this->db->pdo->prepare($sql);
      $stmt->bindValue(':password', $old_pass);
      $stmt->bindValue(':id', $userid);
      $stmt->execute();
      $result = $stmt->fetchall(); 
      if (count($result)> 0) {
        return true;
      }else{
        return false;
      }
    }



    // Change User pass By Id
    public  function changePasswordBysingelUserId($userid, $data){

      $old_pass = $data['old_password'];
      $new_pass = $data['new_password'];


      if ($old_pass == "" || $new_pass == "" ) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
  <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
  <strong>Chyba !</strong> Heslo nesmie byť prázdne!</div>';
          return $msg;
      }elseif (strlen($new_pass) < 6) {
        $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
  <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
  <strong>Chyba!</strong> Nové heslo musí mať aspoň 6 znakov !</div>';
          return $msg;
       }

         $oldPass = $this->CheckOldPassword($userid, $old_pass);
         if ($oldPass == FALSE) {
           $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
     <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
     <strong>Chyba !</strong> Staré heslo sa nezhoduje!</div>';
             return $msg;
         }else{
           $new_pass = SHA1($new_pass);
           $sql = "UPDATE tbl_users SET

            password=:password
            WHERE id = :id";

            $stmt = $this->db->pdo->prepare($sql);
            $stmt->bindValue(':password', $new_pass);
            $stmt->bindValue(':id', $userid);
            $result =   $stmt->execute();

          if ($result) {
            echo "<script>location.href='index.php';</script>";
            Session::set('msg', '<div class="alert alert-Hotovo alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: greenyellow;">
            <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
            <strong>Hotovo !</strong> Zmena hesla úspešná !</div>');

          }else{
            $msg = '<div class="alert alert-danger alert-dismissible mt-3" id="flash-msg" style=" z-index: 20; background-color: red;">
      <button type="button" class="btn btn-outline-secondary bg-danger text-white" onclick="changeStyle()">X</button>
      <strong>Error !</strong> Ups niečo je zle !</div>';
              return $msg;
          }

         }



    }








}
