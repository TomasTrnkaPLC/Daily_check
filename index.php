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
$today_analytics = $analytic->today_counter();
$week_analytics = $analytic->week_counter();
$month_analytics = $analytic->month_counter();
$total_task = $klient->total_task_counter();
$total_client_counter = $klient->total_client_counter();
$total_task_counter_done = $klient->total_task_counter_done();
 ?>



        <!-- start page content wrapper-->
        <div class="page-content-wrapper">
          <!-- start page content-->
         <div class="page-content">

          <!--start breadcrumb-->
          <div class="page-breadcrumb d-none d-sm-flex align-items-center mb-3">
            <div class="breadcrumb-title pe-3"><?php echo $lang->Load_Lang_from_db(1); ?></div>
            <div class="ps-3">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                  <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page">Albert Váš správca</li>
                </ol>
              </nav>
            </div>
           
          </div>
          <!--end breadcrumb-->

         

          <div class="row">
            <div class="col-12 col-lg-4 col-xl-4">
              <div class="card radius-10">
                <div class="card-body"><a href="analytic_planed_today.php">
                  <div class="d-flex align-items-start justify-content-between">
                    <div>
                      <p class="mb-2"><?php echo $lang->Load_Lang_from_db(18); ?></p>
                      <h4 class="mb-0"><?php echo $total_task; ?> </h4>
                    </div>
                    <div class="fs-5">
                      <ion-icon name="ellipsis-vertical-sharp"></ion-icon>
                    </div>
                  </div></a>
                  <div class="mt-3" id="chart1"></div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-4 col-xl-4">
              <div class="card radius-10">
                <div class="card-body"><a href="analytic_planed_today.php">
                  <div class="d-flex align-items-start justify-content-between">
                    <div>
                      <p class="mb-2"><?php echo $lang->Load_Lang_from_db(19); ?></p>
                      <h4 class="mb-0"><?php echo $total_task_counter_done; ?></h4>
                    </div>
                    <div class="fs-5">
                      <ion-icon name="ellipsis-vertical-sharp"></ion-icon>
                    </div>
                  </div>
                  <div class="mt-3" id="chart2"></div>
                </div></a>
              </div>
            </div>
            <div class="col-12 col-lg-4 col-xl-4">
              <div class="card radius-10">
                <div class="card-body"><a href="analytic_planed_today.php">
                  <div class="d-flex align-items-start justify-content-between">
                    <div>
                      <p class="mb-2"><?php echo $lang->Load_Lang_from_db(20); ?></p>
                      <h4 class="mb-0"><?php echo $total_client_counter; ?>  </h4>
                    </div>
                    <div class="fs-5">
                      <ion-icon name="ellipsis-vertical-sharp"></ion-icon>
                    </div>
                  </div>
                  <div class="mt-3" id="chart3"></div>
                </div>
              </div></a>
            </div>
         </div><!--end row-->

         <div class="row">
            <div class="col-12 col-lg-4 col-xl-4">
              <div class="card radius-10">
                <div class="card-body"><a href="analytic_list.php">
                  <div class="d-flex align-items-start justify-content-between">
                    <div>
                      <p class="mb-2"><?php echo $lang->Load_Lang_from_db(85); ?></p>
                      <h4 class="mb-0"><?php echo $today_analytics; ?> </h4>
                    </div></a>
                    <div class="fs-5">
                      <ion-icon name="ellipsis-vertical-sharp"></ion-icon>
                    </div>
                  </div>
                  <div class="mt-3" id="chart1"></div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-4 col-xl-4">
              <div class="card radius-10">
                <div class="card-body"><a href="analytic_list.php">
                  <div class="d-flex align-items-start justify-content-between">
                    <div>
                      <p class="mb-2"><?php echo $lang->Load_Lang_from_db(86); ?></p>
                      <h4 class="mb-0"><?php echo $week_analytics; ?></h4>
                    </div></a>
                    <div class="fs-5">
                      <ion-icon name="ellipsis-vertical-sharp"></ion-icon>
                    </div>
                  </div>
                  <div class="mt-3" id="chart2"></div>
                </div>
              </div>
            </div>
            <div class="col-12 col-lg-4 col-xl-4">
              <div class="card radius-10">
                <div class="card-body"><a href="analytic_list.php">
                  <div class="d-flex align-items-start justify-content-between">
                    <div>
                      <p class="mb-2"><?php echo $lang->Load_Lang_from_db(87); ?></p>
                      <h4 class="mb-0"><?php echo $month_analytics; ?>  </h4>
                    </div></a>
                    <div class="fs-5">
                      <ion-icon name="ellipsis-vertical-sharp"></ion-icon>
                    </div>
                  </div>
                  <div class="mt-3" id="chart3"></div>
                </div>
              </div>
            </div>
         </div><!--end row-->
         


          </div>     
          <!-- end page content-->
         </div>
         <!--end page content wrapper-->

         <?php include 'template/footer.php';?>