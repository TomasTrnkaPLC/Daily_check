<?php
include 'template/header.php';

Session::CheckSession();
$logMsg = Session::get('logMsg');
if (isset($logMsg)) {
  echo $logMsg;
}
$msg = Session::get('msg');
if (isset($msg)) {
  echo $msg;
}
Session::set("msg", NULL);
Session::set("logMsg", NULL);
$sId =  Session::get('roleid');
echo $sId;
if ($sId === '1') { 
 
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addUser'])) {

    $userAdd = $users->addNewUserByAdmin($_POST);
  }

  if (isset($userAdd)) {
    echo 'here';
    echo $userAdd;
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
                  <li class="breadcrumb-item active" aria-current="page"><?php echo $lang->Load_Lang_from_db(21); ?></li>
                </ol>
              </nav>
            </div>
          </div>  
        <!--end breadcrumb-->
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="card radius-10">
                <div class="card-body">
                
                  <h5 class="mb-3"><?php echo $lang->Load_Lang_from_db(21); ?></h5>
                  
                  <h5 class="mb-0 mt-4"><?php echo $lang->Load_Lang_from_db(22); ?></h5>
                  <hr>
                  <div class="row g-3">
            <form class="" action="" method="post">
                <div class="form-group pt-3">
                  <label for="name"><?php echo $lang->Load_Lang_from_db(23); ?></label>
                  <input type="text" name="name"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="username"><?php echo $lang->Load_Lang_from_db(24); ?></label>
                  <input type="text" name="username"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="email"><?php echo $lang->Load_Lang_from_db(25); ?></label>
                  <input type="email" name="email"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="mobile"><?php echo $lang->Load_Lang_from_db(26); ?></label>
                  <input type="text" name="mobile"  class="form-control">
                </div>
                <div class="form-group">
                  <label for="password"><?php echo $lang->Load_Lang_from_db(27); ?></label>
                  <input type="password" name="password" class="form-control">
                </div>
                <div class="form-group">
                  <div class="form-group">
                    <label for="sel1"><?php echo $lang->Load_Lang_from_db(28); ?></label>
                    <select class="form-control" name="roleid" id="roleid">
                                  <option value="1" selected='selected'><?php echo $lang->Load_Lang_from_db(30); ?></option>
                                  <option value="2"><?php echo $lang->Load_Lang_from_db(31); ?></option>
                                  <option value="3"><?php echo $lang->Load_Lang_from_db(32); ?></option>
                                  <option value="4"><?php echo $lang->Load_Lang_from_db(3); ?></option>

                    </select>
                  </div>
                </div>
                <div class="form-group">
                  <button type="submit" name="addUser" class="btn btn-success"><?php echo $lang->Load_Lang_from_db(29); ?></button>
                </div>


            </form>
     

<?php
}else{
  echo "jumm";
 


}
 ?>
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
