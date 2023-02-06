<?php
$filepath = realpath(dirname(__FILE__));
include_once $filepath."/core/Session.php";
Session::init();



spl_autoload_register(function($classes){

  include 'core/'.$classes.".php";

});


$users = new Users();


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['login'])) {
   $userLog = $users->userLoginAuthotication($_POST);
}
if (isset($userLog)) {
  echo $userLog;
}

$logout = Session::get('logout');
if (isset($logout)) {
  echo $logout;
}



 ?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--plugins-->
    <link href="template/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />

    <!-- CSS Files -->
    <link href="template/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="template/assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="template/assets/css/style.css" rel="stylesheet">
    <link href="template/assets/css/icons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <title>Albert - Váš správca systému</title>
  </head>
  <body class="bg-white">
    
 <!--start wrapper-->
    <div class="wrapper">
    
        <div class="row g-0 m-0">
        <div class="col-xl-6 col-lg-12">
          <div class="login-cover-wrapper">
           <div class="card shadow-none">
            <div class="card-body">
              <div class="text-center">
                <h4>Daily Check</h4>
                <p>Prosím prihláste sa Emailom a heslom</p>
              </div>
              <form class="form-body row g-3" action="" method="post">
                <div class="col-12">
                  <label for="inputEmail" class="form-label">Email</label>
                  
                  <input type="email" name="email"  class="form-control">
                </div>
                <div class="col-12">
                  <label for="inputPassword" class="form-label">Heslo</label>
                  <input type="password" name="password"  class="form-control">
                </div>
                
                
                <div class="col-12 col-lg-12">
                  <div class="d-grid">
                    <button type="submit" name="login" class="btn btn-primary">Prihlásenie</button>
                    
                  </div>
                </div>
                
               
              </form>
            </div>
          </div>
         </div>
        </div>
        <div class="col-xl-6 col-lg-12">
          <div class=" top-0 h-100 d-xl-block d-none login-cover-img">
            <div class="text-white p-5 w-100">
             
            </div>
          </div>
        </div>
      </div><!--end row-->
    </div>
     
  <!--end wrapper-->


  </body>
</html>