<?php include 'template/header.php';

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

if (isset($_GET['remove'])) {
  $remove = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['remove']);
  $removeUser = $users->deleteUserById($remove);
}

if (isset($removeUser)) {
  echo $removeUser;
}
if (isset($_GET['deactive'])) {
  $deactive = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['deactive']);
  $deactiveId = $users->userDeactiveByAdmin($deactive);
}

if (isset($deactiveId)) {
  echo $deactiveId;
}
if (isset($_GET['active'])) {
  $active = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['active']);
  $activeId = $users->userActiveByAdmin($active);
}

if (isset($activeId)) {
  echo $activeId;
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
                  <li class="breadcrumb-item active" aria-current="page"><?php echo $lang->Load_Lang_from_db(7); ?></li>
                </ol>
              </nav>
            </div>
		   </div>
          <!--end breadcrumb-->

				
				<hr/>
				<div class="card">
					<div class="card-body">
						<div class="table-responsive">
							<table id="example2" class="table table-striped table-bordered">
								<thead>
									<tr>
										<th  class="text-center">SL</th>
									
											<th  class="text-center"><?php echo $lang->Load_Lang_from_db(23). ' '. $lang->Load_Lang_from_db(24); ?></th>
										    <th  class="text-center"><?php echo $lang->Load_Lang_from_db(74); ?></th>
										    <th  class="text-center"><?php echo $lang->Load_Lang_from_db(36); ?></th>
											<th  class="text-center"><?php echo $lang->Load_Lang_from_db(77); ?></th>
									
									
									</tr>
									
								</thead>
								<tbody>
											<?php

											$allUser = $klient->SelectAllUserPlanToday();

											if ($allUser) {
												$i = 0;
												foreach ($allUser as  $value) {
												$i++;

											?>

											<tr class="text-center"
											<?php if (Session::get("id") == $value->id) {
												echo " ";
											} ?>
											>

												<td><?php echo $i; ?></td>
												<td><?php echo $klient->selectClientNameById($value->client_id) ; ?></td>
												<td><?php echo $klient->SelectCareNameById($value->care_type) ; ?></td>
												<td><?php echo $value->status; ?> </td>
												
												<td><?php $vysledok = $value->result_switch;
												if ($vysledok == NULL ){
													echo "";
												}elseif ($vysledok == 'on'){
													echo "<style='
													background-color: red;
													color: white;'>
												Ok</style>";
												}else{
													echo "Chyba";	
												}  ?> </td>
											
											<?php if ($_SESSION['roleid'] == 1 or $_SESSION['roleid'] == 2 ) { ?>
												<td><a class="btn btn-success btn-sm" href="analytic_detail.php?id=<?php echo $value->id;?>"><?php echo $lang->Load_Lang_from_db(41); ?></a></td>
												<?php } ?>
											</tr>
											<?php }}else{ ?>
											<tr class="text-center">
											<td>Žiaden záznam!</td>
											</tr>
											<?php } ?>

                  </tbody>
							
							</table>
						</div>
					</div>
				</div>
             

          </div>
          <!-- end page content-->
         </div>
         

		 <?php include 'template/footer.php';?>