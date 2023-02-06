
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
                  <li class="breadcrumb-item active" aria-current="page"><?php echo $lang->Load_Lang_from_db(62); ?></li>
                </ol>
              </nav>
            </div>
            
          </div>
          <!--end breadcrumb-->

    <?php
    $getUinfo = $klient->getUserInfoById($userid);
    if ($getUinfo) {
    ?>
               <div class="row">
              <div class="col-12 col-lg-8 col-xl-9">
                <div class="card overflow-hidden radius-10">
                 
                  <div class="card-body">
                    <div class="mt-5 d-flex align-items-start justify-content-between">
                   
                        <h3 class="mb-2"><?php echo $getUinfo->meno; ?> <?php echo $getUinfo->priezvisko; ?></h3>
                       
                     
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-body">
                    <h4 class="mb-3"><?php echo $lang->Load_Lang_from_db(63); ?></h4>
                  
                  </div>
                  <div class="card-body">
                    <h4 class="mb-3"><?php echo $lang->Load_Lang_from_db(52); ?></h4>
                    <p class=""><?php echo $getUinfo->note; ?></p>
              
                  </div>
                  <div class="card-body">
                    <h4 class="mb-3"><?php echo $lang->Load_Lang_from_db(64); ?></h4>
                  
                    		<div class="table-responsive">
						            	<table id="example2" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th  class="text-center">SL</th>
                                <th  class="text-center">Úkon</th>
                                <th  class="text-center">Planovaný čas </th>
                                <th  class="text-center">Poznámka</th>
                                <th  class="text-center">Status</th>
                                <th  class="text-center">Akcia</th>
                              </tr>
                            </thead>
							            	<tbody>
                            <?php

                                    $allUser = $klient->select_care_for_today($userid);

                                    if ($allUser) {
                                      $i = 0;
                                      foreach ($allUser as  $value) {
                                        $i++;
                                        if ($i == 25){
                                              break;
                                            }
                                        ?>
                                    <tr class="text-center">
                                      <td><?php echo $i; ?></td>
                                      <td><?php echo $klient->care_name($value->care_type); ?></td>
                                      <td><?php echo $value->care_time; ?> </td>
                                      <td><?php echo $value->note; ?> </td>
                                      <td><?php echo $value->status; ?> </td>
                                      <td><a class="btn btn-success btn-sm" href="client_care_action.php?id=<?php echo $value->id;?>">Akcia</a></td>
                                    </tr>
                                    <?php }}else{ ?>
                                    <tr class="text-center">
                                    <td>Žiaden záznam!</td>
                                    </tr>
                                    <?php } ?>
							
                              </table>
                          </div>
                    </div>
                    <div class="card-body">
                    <h4 class="mb-3"><?php echo $lang->Load_Lang_from_db(65); ?></h4>
                  
                    		<div class="table-responsive">
						            	<table id="example2" class="table table-striped table-bordered">
                            <thead>
                              <tr>
                                <th  class="text-center">SL</th>
                                <th  class="text-center">Úkon</th>
                                <th  class="text-center">Planovaný čas </th>
                                <th  class="text-center">Poznámka</th>
                                <th  class="text-center">Status</th>
                                <th  class="text-center">Čas ukončenia</th>
                                <th  class="text-center">Ošetrovaťeľ</th>
                              </tr>
                            </thead>
							            	<tbody>
                            <?php

                                    $allUser = $klient->select_care_for_all($userid);

                                    if ($allUser) {
                                      $i = 0;
                                      foreach ($allUser as  $value) {
                                      $i++;

                                    ?>

                                    <tr class="text-center">

                                      <td><?php echo $i; ?></td>
                                      <td><?php echo $klient->care_name($value->care_type); ?></td>
                                      <td><?php echo $value->care_time; ?> </td>
                                      <td><?php if ($value->result_switch == 'on'){
                                       echo $lang->Load_Lang_from_db(80); 
                                      } elseif($value->result_switch == 'off'){
                                        echo $lang->Load_Lang_from_db(81);
                                      }?> </td>
                                      <td><?php echo $value->status; ?> </td>
                                      <td><?php echo $value->care_done; ?> </td>
                                      <?php if ($value->status == 'Hotovo'){?>
                                        <td><?php echo $users->selectfullname($value->user_id); ?> </td>
                                      <?php }else{ ?>
                                        <td> </td>
                                        <?php } ?>
                                    </tr>
                                    <?php }}else{ ?>
                                    <tr class="text-center">
                                    <td>Žiaden záznam!</td>
                                    </tr>
                                    <?php } ?>
							
                              </table>
                          </div>
                    </div>
                </div>
              </div>
              <?php if ($producion_mode != 'daily-check'){ ?>   
                        <div class="col-12 col-lg-4 col-xl-3">
                          <div class="card radius-10">
                            <div class="card-body">
                              <h5 class="mb-3"><?php echo $lang->Load_Lang_from_db(61); ?></h5>
                              <p class="mb-0"><ion-icon name="compass-sharp" class="me-2"></ion-icon><?php echo $getUinfo->izba; ?></p>
                            </div>
                            <div class="card-body">
                              <h5 class="mb-3">Krvná skupina</h5>
                              <p class="mb-0"><ion-icon name="compass-sharp" class="me-2"></ion-icon><?php echo $getUinfo->blood_type; ?></p>
                            </div>
                          </div>

                          <div class="card radius-10">
                            <div class="card-body">
                              <h5 class="mb-3"><?php echo $lang->Load_Lang_from_db(67); ?></h5>
                              <p class=""><?php echo $lang->Load_Lang_from_db(23); ?>:<?php echo $getUinfo->r_meno; ?></p>
                              <p class=""><?php echo $lang->Load_Lang_from_db(34); ?>: <?php echo $getUinfo->r_titul; ?> <?php echo $getUinfo->r_priezvisko; ?></p>
                              <p class=""><?php echo $lang->Load_Lang_from_db(67); ?>: <?php echo $getUinfo->r_ulica	; ?>  <?php echo $getUinfo->r_cislo_domu; ?>  <?php echo $getUinfo->r_mesto; ?>  <?php echo $getUinfo->r_psc; ?></p>
                              <p class=""><?php echo $lang->Load_Lang_from_db(68); ?>: <?php echo $getUinfo->r_vztah	; ?></p>
                              <p class=""><?php echo $lang->Load_Lang_from_db(69); ?>: <?php echo $getUinfo->r_telefon; ?></p>
                              <p class=""><?php echo $lang->Load_Lang_from_db(25); ?>: <?php echo $getUinfo->r_mail; ?></p>
                  
                            </div>
                          </div>


                        </div>
                        <?php } ?>
            </div><!--end row-->


              


          </div>
          <!-- end page content-->
         </div>
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
