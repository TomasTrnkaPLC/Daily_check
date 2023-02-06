<?php
include 'template/header.php';
Session::CheckSession();
$sId =  Session::get('roleid');
if ($sId < '2') { ?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addUser'])) {

  $userAdd = $klient->addcklinetcaretype($_POST);
}

if (isset($userAdd)) {
  echo $userAdd;
}
if (isset($_GET['id'])) {
	$clientid = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['id']);
  
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
                  <li class="breadcrumb-item active" aria-current="page"><?php echo $lang->Load_Lang_from_db(54); ?> <b> <?php echo $klient->selectClientName($clientid); ?></b></li>
                </ol>
              </nav>
            </div>
            
          </div>
          <!--end breadcrumb-->
          <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="card radius-10">
                <div class="card-body">
                
                  <h5 class="mb-3"><?php echo $lang->Load_Lang_from_db(15); ?></h5>
                  
                  <h5 class="mb-0 mt-4"><?php echo $lang->Load_Lang_from_db(22); ?></h5>
                  <hr>
                  <div class="row g-3">
            <form class="" action="" method="post">
               <input type="hidden" name="client_id" value="<?php echo $clientid; ?>">
                <div class="form-group pt-3">
                <label for="sel_care"><?php echo $lang->Load_Lang_from_db(55); ?></label>
                <select name='sel_care' class="form-select mb-3">
                    
                    <?php
                    	$allUser = $klient->selectAllCare();
                      foreach($allUser as  $value){
                            echo "<option value='".$value->id."'>".$value->item."</option>";
                          }

                          ?>
                 </select>      
                </div>
          
                <div class="form-group pt-3">
                  <label for="link"><?php echo $lang->Load_Lang_from_db(56); ?></label>
                  <input class="result form-control" type="datetime-local" id="date-time" name='care_time' >
                </div>

                <div class="form-group pt-3">
                  <label for="link"><?php echo $lang->Load_Lang_from_db(89); ?></label>
                  <input class="result form-control" type="number" name='end_limit' min="1" max="120" value='60'>
                </div>

                <div class="form-group pt-3">
                  <label for="link"><?php echo $lang->Load_Lang_from_db(57); ?></label>
                  <input class="result form-control" type="number" name='care_repeat_time' min="1" max="60">
                </div>
             

                <div class="form-group pt-3">  
                  <label for="link"><?php echo $lang->Load_Lang_from_db(58); ?></label>
                  <input  type="checkbox" value='On' name='care_repeat_day' >
                </div>
                <div class="form-group pt-3"> 
                  <label for="link"><?php echo $lang->Load_Lang_from_db(59); ?></label>
                  <input  type="checkbox" value='On' name='care_repeat_week' >
                 
                </div>
                <div class="form-group pt-3">
                  <label for="note"><?php echo $lang->Load_Lang_from_db(52); ?></label>
                  <input type="text" name="note"  class="form-control" autocomplete="off">
                </div>
          
                
                <div class="form-group">
                  <button type="submit" name="addUser" class="btn btn-success"><?php echo $lang->Load_Lang_from_db(29); ?></button>
                </div>


            </form>
     

<?php
}else{

  header('Location:index.php');



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
