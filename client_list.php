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
							<table class="table table-striped table-bordered">
								<thead>
									<tr>
										<th  class="text-center">SL</th>									
											<th  class="text-center"><?php echo $lang->Load_Lang_from_db(23); ?></th>
											<th  class="text-center"><?php echo $lang->Load_Lang_from_db(52); ?></th>
											<th  class="text-center"><?php echo $lang->Load_Lang_from_db(92); ?></th>
											<th  class="text-center"><?php echo $lang->Load_Lang_from_db(93); ?></th>	
											<th  class="text-center"><?php echo $lang->Load_Lang_from_db(38); ?></th>	
											<th  class="text-center"><?php echo $lang->Load_Lang_from_db(94); ?></th>									
									</tr>
									
								</thead>
								<tbody>
											<?php

											$allUser = $klient->selectAllUserData();

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
												<td><?php echo $value->meno; ?></td>
												<td><?php echo $value->model; ?> </td>
												<td><?php echo $value->Time_1; ?> </td>
												<td><?php echo $value->Time_2; ?> </td>
											    <td><a class="btn btn-success btn-sm" href="client_profile.php?id=<?php echo $value->id;?>"><?php echo $lang->Load_Lang_from_db(41); ?></a></td>
												<td><a class="btn btn-success btn-sm" href="client_edit.php?id=<?php echo $value->id;?>"><?php echo $lang->Load_Lang_from_db(95); ?></a></td>
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