<?php include 'template/header.php';
Session::CheckSession();

if (isset($_GET['id'])) {
  $userid = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['id']);

}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
  $updateUser = $users->updateUserByIdInfo($userid, $_POST);

}
if (isset($updateUser)) {
  echo $updateUser;
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
                  <li class="breadcrumb-item active" aria-current="page"><?php echo $lang->Load_Lang_from_db(10); ?></li>
                </ol>
              </nav>
            </div>
            
          </div>
          <!--end breadcrumb-->

    <?php
    $getUinfo = $users->getUserInfoById($userid);
    if ($getUinfo) {
    ?>
      <div class="row">
            <div class="col-lg-8 mx-auto">
              <div class="card radius-10">
                <div class="card-body">
                
                  
                  <h5 class="mb-0 mt-4"><?php echo $lang->Load_Lang_from_db(22); ?></h5>
                  <hr>
                  <div class="row g-3">
                  <form class="" action="" method="POST">  
                    <div class="col-6">
                       <label class="form-label"><?php echo $lang->Load_Lang_from_db(23); ?></label>
                       <?php if (Session::get("roleid") < '3')  {?>
                                 <input type="text" name="name" value="<?php echo $getUinfo->name; ?>" class="form-control">
                               <?php
                               }else{ ?>
                                 <input type="text" name="name" value="<?php echo $getUinfo->name; ?>" class="form-control" disabled>
                               <?php  }?>
                      
                    </div>
                    <div class="col-6">
                      
                     <label class="form-label"><?php echo $lang->Load_Lang_from_db(24); ?></label>
                     <?php if (Session::get("roleid") < '3')  { ?>
                         <input type="text" name="username" value="<?php echo $getUinfo->username; ?>" class="form-control">
                         <?php }else{ ?>
                        <input type="text" name="username" value="<?php echo $getUinfo->username; ?>" class="form-control" disabled>
                      <?php  }?>
                     </div>
                     <div class="col-6">
                       <label class="form-label"><?php echo $lang->Load_Lang_from_db(25); ?></label>
                    <?php if (Session::get("roleid") < '3')  { ?>
                               <input type="email" id="email" name="email" value="<?php echo $getUinfo->email; ?>" class="form-control">
                        <?php
                         }else{ ?>
                           <input type="email" id="email" name="email" value="<?php echo $getUinfo->email; ?>" class="form-control" disabled>
                        <?php  }?> 
                       </div>
                   <div class="col-6">
                     <label class="form-label"><?php echo $lang->Load_Lang_from_db(26); ?></label>
                    
                       <?php if (Session::get("roleid") < '3')  { ?>
                            <input type="text" id="mobile" name="mobile" value="<?php echo $getUinfo->mobile; ?>" class="form-control">
                        <?php } else{ ?>
                            <input type="text" id="mobile" name="mobile" value="<?php echo $getUinfo->mobile; ?>" class="form-control" disabled>
                        <?php  }?> 
                   </div>
                   <?php 
                
                   if (Session::get("roleid") == '1') { ?>

                              <div class="form-group ">
                                <div class="form-group">
                                  <label for="sel1"><?php echo $lang->Load_Lang_from_db(28); ?></label>
                                  <select class="form-control" name="roleid" id="roleid">

                                  <?php

                                if($getUinfo->roleid == '1'){?>
                                  <option value="1" selected='selected'><?php echo $lang->Load_Lang_from_db(30); ?></option>
                                  <option value="2"><?php echo $lang->Load_Lang_from_db(31); ?></option>
                                  <option value="3"><?php echo $lang->Load_Lang_from_db(32); ?></option>
                                  <option value="4"><?php echo $lang->Load_Lang_from_db(3); ?></option>
                                <?php }elseif($getUinfo->roleid == '2'){?>
                                  <option value="2" selected='selected'><?php echo $lang->Load_Lang_from_db(31); ?></option>
                                  <option value="1"><?php echo $lang->Load_Lang_from_db(30); ?></option>
                                  <option value="3"><?php echo $lang->Load_Lang_from_db(32); ?></option>
                                  <option value="4"><?php echo $lang->Load_Lang_from_db(3); ?></option>
                                <?php }elseif($getUinfo->roleid == '3'){ ?>
                                  <option value="3" selected='selected'><?php echo $lang->Load_Lang_from_db(32); ?></option>
                                  <option value="1"><?php echo $lang->Load_Lang_from_db(30); ?></option>
                                  <option value="2"><?php echo $lang->Load_Lang_from_db(31); ?></option>
                                  <option value="4"><?php echo $lang->Load_Lang_from_db(3); ?></option>
                                <?php } elseif($getUinfo->roleid == '4'){ ?>
                                  <option value="4" selected='selected'><?php echo $lang->Load_Lang_from_db(3); ?></option>
                                  <option value="2"><?php echo $lang->Load_Lang_from_db(31); ?></option>
                                  <option value="3"><?php echo $lang->Load_Lang_from_db(32); ?></option>
                                  <option value="1"><?php echo $lang->Load_Lang_from_db(30); ?></option>
                                <?php } ?>
                                  </select>
                                </div>
                              </div>

                              <?php }else{?>
                              <input type="hidden" name="roleid" value="<?php echo $getUinfo->roleid; ?>">
                              <?php } ?>

                              <?php if (Session::get("id") == $getUinfo->id) {?>


                              <div class="form-group">
                                <button type="submit" name="update" class="btn btn-success"><?php echo $lang->Load_Lang_from_db(49); ?></button>
                                <a class="btn btn-primary" href="changepass.php?id=<?php echo $getUinfo->id;?>"><?php echo $lang->Load_Lang_from_db(9); ?></a>
                              </div>
                              <?php } elseif(Session::get("roleid") == '1') {?>


                              <div class="form-group">
                                <button type="submit" name="update" class="btn btn-success"><?php echo $lang->Load_Lang_from_db(49); ?></button>
                                <a class="btn btn-primary" href="changepass.php?id=<?php echo $getUinfo->id;?>"><?php echo $lang->Load_Lang_from_db(9); ?></a>
                              </div>
                              <?php } elseif(Session::get("roleid") == '2') {?>


                              <div class="form-group">
                                <button type="submit" name="update" class="btn btn-success"><?php echo $lang->Load_Lang_from_db(49); ?></button>

                              </div>

                              <?php   }else{ ?>
                                  <div class="form-group">

                                    <a class="btn btn-primary" href="index.php">Ok</a>
                                  </div>
                                <?php } ?>


                              </form>
                              <?php }else{

header('Location:index.php');
} ?>



                 </div>                
               
              </div>
            </div>
          </div><!--end row-->

          </div>
          <!-- end page content-->
         </div>
      



    <?php include 'template/footer.php';?>
