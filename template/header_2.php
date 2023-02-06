<!doctype html>
<html lang="en" class="light-theme">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--plugins-->

    <!--plugins-->
    <link href="template/assets/plugins/perfect-scrollbar/css/perfect-scrollbar.css" rel="stylesheet" />
    <link href="template/assets/plugins/datatable/css/dataTables.bootstrap5.min.css" rel="stylesheet" />

    <!-- CSS Files -->
    <link href="template/assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="template/assets/css/bootstrap-extended.css" rel="stylesheet">
    <link href="template/assets/css/style.css" rel="stylesheet">
    <link href="template/assets/css/icons.css" rel="stylesheet">
    <link href="template/assets/css/trumbowyg.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500&display=swap" rel="stylesheet">

    <!--Theme Styles-->
    <link href="template/assets/css/dark-theme.css" rel="stylesheet" />
    <link href="template/assets/css/header-colors.css" rel="stylesheet" />
    <!-- JS Files-->
    <script src="template/assets/js/jquery.min.js"></script>
    <script src="template/assets/js/jquery-ui.js"></script>
    <script src="template/assets/js/bootstrap.bundle.min.js"></script>

    <title>Albert - Denna Kontrola</title>
    
  </head>
  <script>
 
      function changeStyle() {
        document.getElementById('flash-msg').style.display = 'none';
        
      }
  </script>
  <body>
  <?php


$filepath = realpath(dirname(__FILE__));

include_once $filepath."/../core/Session.php";
Session::init();

ini_set ('display_errors', 1);
ini_set ('display_startup_errors', 1);
error_reporting (E_ALL);

spl_autoload_register(function($classes){

  include 'core/'.$classes.".php";

});
include_once $filepath."/../core/Language.php";


$users = new Users();
$klient = new Klient();
$care = new Care();
$analytic = new Analytic();
$lang = new Language();

$producion_mode = $users->Production_mode(); 

if (isset($_GET['action']) && $_GET['action'] == 'logout') {

  Session::destroy();
}

if (Session::get('id') == TRUE) { 
  ?> 

 <!--start wrapper-->
    <div class="wrapper">
       <!--start sidebar wrapper-->
        <div class="mini-sidebar-wrapper">
           <div class="mini-sidebar-header">
              <img src="template/assets/images/logo-icon-2.png" alt="" class="logo-icon">
           </div>
           <div class="mini-sidebar-navigation d-flex align-items-center justify-content-center">
            <ul class="nav nav-pills flex-column">
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="<?php echo $lang->Load_Lang_from_db(1); ?>">
                <a href="javascript:;" class="nav-link" data-bs-toggle="pill" data-bs-target="#dashboard"><ion-icon name="home-sharp"></ion-icon></a>
              </li>
              
												<?php if ($_SESSION['roleid'] == 1 or $_SESSION['roleid'] == 2 ) { ?>
                                <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="<?php echo $lang->Load_Lang_from_db(2); ?>">
                                  <a href="javascript:;" class="nav-link" data-bs-toggle="pill" data-bs-target="#authentication"><ion-icon name="person-circle-sharp"></ion-icon></a>
                                </li>
                       <?php }  if ($producion_mode != 'daily-check'){ ?>
                <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="<?php echo $lang->Load_Lang_from_db(3); ?>">
                <a href="javascript:;" class="nav-link" data-bs-toggle="pill" data-bs-target="#recepcia"><ion-icon name="newspaper-sharp"></ion-icon></a>
              </li>
            <?php } ?>  
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="<?php echo $lang->Load_Lang_from_db(4); ?>">
                <a href="javascript:;" class="nav-link" data-bs-toggle="pill" data-bs-target="#klient"><ion-icon name="newspaper-sharp"></ion-icon></a>
              </li>
              <?php if ($_SESSION['roleid'] == 1 or $_SESSION['roleid'] == 2 ) { ?>
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="<?php echo $lang->Load_Lang_from_db(5); ?>">
                <a href="javascript:;" class="nav-link" data-bs-toggle="pill" data-bs-target="#care"><ion-icon name="checkmark-circle-outline"></ion-icon></a>
              </li>
              <?php } ?>
              <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="right" title="<?php echo $lang->Load_Lang_from_db(83); ?>">
                <a href="javascript:;" class="nav-link" data-bs-toggle="pill" data-bs-target="#analytic"><ion-icon name="pie-chart"></ion-icon></a>
              </li>

            </ul>
            </div>
            <div class="toggle-menu-wrapper">
               <div class="toggle-menu-button">
                <ion-icon name="chevron-back-sharp"></ion-icon>      
               </div>
            </div>
         </div>

         <!--start submenu wrapper-->
         <div class="sidebar-submenu-wrapper">
          <div class="tab-content">
            <div class="tab-pane fade" id="dashboard">
              <div class="list-group list-group-flush">
                <div class="list-group-item">
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-0"><?php echo $lang->Load_Lang_from_db(1); ?> </h5>
                  </div>
                  <small class="mb-0"><?php echo $lang->Load_Lang_from_db(6); ?></small>
                </div>
                <a href="index.php" class="list-group-item d-flex align-items-center"><ion-icon name="grid-outline"></ion-icon><?php echo $lang->Load_Lang_from_db(12); ?></a>
              
              </div>
            </div>
            
            <div class="tab-pane fade" id="authentication">
              <div class="list-group list-group-flush">
                <div class="list-group-item">
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-0"><?php echo $lang->Load_Lang_from_db(2); ?></h5>
                  </div>
                  <small class="mb-0"><?php echo $lang->Load_Lang_from_db(6); ?></small>
                </div>
                <a href="user_list.php" class="list-group-item d-flex align-items-center"><ion-icon name="archive-outline"></ion-icon><?php echo $lang->Load_Lang_from_db(7); ?></a>
                <a href="add_user.php" class="list-group-item d-flex align-items-center"><ion-icon name="dice-outline"></ion-icon><?php echo $lang->Load_Lang_from_db(13); ?></a>
                <a href="pass_change.php" class="list-group-item d-flex align-items-center"><ion-icon name="easel-outline"></ion-icon><?php echo $lang->Load_Lang_from_db(9); ?></a>
                
              </div>
            </div>

            <div class="tab-pane fade" id="recepcia">
              <div class="list-group list-group-flush">
                <div class="list-group-item">
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-0"><?php echo $lang->Load_Lang_from_db(3); ?></h5>
                  </div>
                  <small class="mb-0"><?php echo $lang->Load_Lang_from_db(6); ?></small>
                </div>
                <a href="reception_list.php" class="list-group-item d-flex align-items-center"><ion-icon name="archive-outline"></ion-icon><?php echo $lang->Load_Lang_from_db(7); ?></a>
                <a href="add_record_reception.php" class="list-group-item d-flex align-items-center"><ion-icon name="dice-outline"></ion-icon><?php echo $lang->Load_Lang_from_db(14); ?></a>
                
                
              </div>
            </div>

            <div class="tab-pane fade" id="klient">
              <div class="list-group list-group-flush">
                <div class="list-group-item">
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-0"><?php echo $lang->Load_Lang_from_db(4); ?></h5>
                  </div>
                  <small class="mb-0"><?php echo $lang->Load_Lang_from_db(6); ?></small>
                </div>
                <a href="client_list.php" class="list-group-item d-flex align-items-center"><ion-icon name="archive-outline"></ion-icon><?php echo $lang->Load_Lang_from_db(7); ?></a>
                <?php if ($_SESSION['roleid'] == 1 or $_SESSION['roleid'] == 2 ) { ?>
                  <a href="add_client.php" class="list-group-item d-flex align-items-center"><ion-icon name="dice-outline"></ion-icon><?php echo $lang->Load_Lang_from_db(17); ?></a>
                  <a href="add_client_care.php" class="list-group-item d-flex align-items-center"><ion-icon name="dice-outline"></ion-icon><?php echo $lang->Load_Lang_from_db(16); ?></a>
                <?php } ?>
              </div>
            </div>

            <div class="tab-pane fade" id="care">
              <div class="list-group list-group-flush">
                <div class="list-group-item">
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-0"><?php echo $lang->Load_Lang_from_db(5); ?></h5>
                  </div>
                  <small class="mb-0"><?php echo $lang->Load_Lang_from_db(6); ?></small>
                </div>
                <a href="care_list.php" class="list-group-item d-flex align-items-center"><ion-icon name="archive-outline"></ion-icon><?php echo $lang->Load_Lang_from_db(7); ?></a>
                <a href="add_care.php" class="list-group-item d-flex align-items-center"><ion-icon name="dice-outline"></ion-icon><?php echo $lang->Load_Lang_from_db(15); ?></a>
                
              </div>
            </div>


            
            <div class="tab-pane fade" id="analytic">
              <div class="list-group list-group-flush">
                <div class="list-group-item">
                  <div class="d-flex w-100 justify-content-between">
                    <h5 class="mb-0"><?php echo $lang->Load_Lang_from_db(83); ?></h5>
                  </div>
                  <small class="mb-0"><?php echo $lang->Load_Lang_from_db(6); ?></small>
                </div>
                <a href="analytic_list.php" class="list-group-item d-flex align-items-center"><ion-icon name="archive-outline"></ion-icon><?php echo $lang->Load_Lang_from_db(7); ?></a>
     
                
              </div>
            </div>

          </div>
        </div><!--end submenu wrapper-->
        <!--end sidebar wrapper-->

  
        <?php
  


}else{ ?>
<?php echo $lang->Load_Lang_from_db(11); ?><a class="nav-link" href="login.php"><i class="fas fa-sign-in-alt mr-2"></i>TU</a>
  
<?php } 

if (Session::get('id') == TRUE) { ?>
<!--start top header-->
<header class="top-header">
            <nav class="navbar navbar-expand gap-3">
              <div class="mobile-menu-button"><ion-icon name="menu-sharp"></ion-icon></div>
              <form class="searchbar">
                <div class="position-absolute top-50 translate-middle-y search-icon ms-3"><ion-icon name="search-sharp"></ion-icon></div>
                <input class="form-control" type="text" placeholder="">
                <div class="position-absolute top-50 translate-middle-y search-close-icon"><ion-icon name="close-sharp"></ion-icon></div>
             </form>
             <div class="top-navbar-right ms-auto">

              <ul class="navbar-nav align-items-center">
               
                <li class="nav-item">
                  <a class="nav-link dark-mode-icon" href="javascript:;">
                    <div class="mode-icon">
                      <ion-icon name="moon-sharp"></ion-icon> 
                    </div>
                  </a>
                </li>
              
                
                <li class="nav-item dropdown dropdown-user-setting">
                  <a class="nav-link dropdown-toggle dropdown-toggle-nocaret" href="javascript:;" data-bs-toggle="dropdown">
                    <div class="user-setting">
                      <img src="template/assets/images/user.png" class="user-img" alt="">
                 
                    </div>
                  </a>
                  <ul class="dropdown-menu dropdown-menu-end">
                    <li>
                       <a class="dropdown-item" href="javascript:;">
                         <div class="d-flex flex-row align-items-center gap-2">
                         
                            <div class="">
                              <h6 class="mb-0 dropdown-user-name"><?php
                                    $username = Session::get('username');
                                    if (isset($username)) {
                                      echo $username;
                                    }
                                    ?></h6>
                              <small class="mb-0 dropdown-user-designation text-secondary"><?php $role = $users->selectRole(Session::get("roleid") );  echo($role);?></small>
                              
                            </div>
                         </div>
                       </a>
                     </li>
                     <li><hr class="dropdown-divider"></li>
                     <li>
                        <a class="dropdown-item" href="javascript:;">
                           <div class="d-flex align-items-center">
                             <div class=""><ion-icon name="person-outline"></ion-icon></div>
                             <div class="ms-3"><span><?php echo $lang->Load_Lang_from_db(10); ?></span></div>
                           </div>
                         </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="pass_change.php">
                           <div class="d-flex align-items-center">
                             <div class=""><ion-icon name="settings-outline"></ion-icon></div>
                             <div class="ms-3"><span><?php echo $lang->Load_Lang_from_db(9); ?></span></div>
                           </div>
                         </a>
                      </li>
                      <li>
                        <a class="dropdown-item" href="index.php">
                           <div class="d-flex align-items-center">
                             <div class=""><ion-icon name="speedometer-outline"></ion-icon></div>
                             <div class="ms-3"><span><?php echo $lang->Load_Lang_from_db(1); ?></span></div>
                           </div>
                         </a>
                      </li>
                      
                      
                      <li><hr class="dropdown-divider"></li>
                      <li>
                        <a class="dropdown-item" href="?action=logout">  
                           <div class="d-flex align-items-center">
                             <div class=""><ion-icon name="log-out-outline"></ion-icon></div>
                             <div class="ms-3"><span><?php echo $lang->Load_Lang_from_db(8); ?></span></div>
                           </div>
                         </a>
                      </li>
                  </ul>
                </li>

               </ul>

              </div>
            </nav>
          </header>
        <!--end top header-->

        <?php } ?>        
 