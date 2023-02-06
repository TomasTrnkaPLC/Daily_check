<?php
include 'template/header.php';
Session::CheckSession();
 ?>
 <?php

 if (isset($_GET['id'])) {
   $userid = (int)$_GET['id'];

 }
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['changepass'])) {
    $changePass = $users->changePasswordBysingelUserId($userid, $_POST);
 }
if (isset( $changePass)) {
   echo  $changePass;
 }
  ?>


     <!-- start page content wrapper-->
     <div class="page-content-wrapper">
          <!-- start page content-->
         <div class="page-content">

          <!--start breadcrumb-->
          <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
           
            <div class="ps-3">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                  <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page"><?php echo $lang->Load_Lang_from_db(9); ?></li>
                </ol>
              </nav>
            </div>
            
          </div>
          <!--end breadcrumb-->
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="card radius-10">
                <div class="card-body">
                
                  <h5 class="mb-3"><?php echo $lang->Load_Lang_from_db(9); ?></h5>
                  
                 
                  <hr>
                  <div class="row g-3">

          <form class="" action="" method="POST">
              <div class="form-group">
                <label for="old_password"><?php echo $lang->Load_Lang_from_db(33); ?></label>
                <input type="password" name="old_password"  class="form-control">
              </div>
              <div class="form-group">
                <label for="new_password"><?php echo $lang->Load_Lang_from_db(34); ?></label>
                <input type="password" name="new_password"  class="form-control">
              </div>


              <div class="form-group">
                <button type="submit" name="changepass" class="btn btn-success"><?php echo $lang->Load_Lang_from_db(9); ?></button>
              </div>


          </form>
          </div>                
               
               </div>
             </div>
           </div><!--end row-->
 
           </div>
           <!-- end page content-->
          </div>


  <?php
  include 'template/footer.php';


  ?>
