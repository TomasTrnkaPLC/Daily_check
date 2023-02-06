
<?php include 'template/header_3.php';
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
                   
                        <h3 class="mb-2"><?php echo $getUinfo->meno; ?></h3>
                       
                     
                    </div>
                  </div>
                </div>
                <div class="card">
                  <div class="card-body">
                   


                    <div class="card-body">
                    <h4 class="mb-3"><?php echo $lang->Load_Lang_from_db(65); ?></h4>
                  
                    		<div class="table-responsive">
                        <table border="0" cellspacing="5" cellpadding="5">
                                  <tbody><tr>
                                      <td>Od:</td>
                                      <td><input type="datetime-local" id="min" name="min"></td>
                             
                                      <td>Do:</td>
                                      <td><input type="datetime-local" id="max" name="max"></td>  
                                    
                                  
                                  </tr>
                              </tbody></table>
						            	<table id="analytic_detail" class="table table-striped table-bordered">
                            
                            <thead>
                              <tr>
                                <th  class="text-center">SL</th>
                                <th  class="text-center"><?php echo $lang->Load_Lang_from_db(5); ?></th>
                                <th  class="text-center"><?php echo $lang->Load_Lang_from_db(70); ?></th>
                                <th  class="text-center"><?php echo $lang->Load_Lang_from_db(52); ?></th>
                                <th  class="text-center"><?php echo $lang->Load_Lang_from_db(36); ?></th>
                                <th  class="text-center"><?php echo $lang->Load_Lang_from_db(75); ?></th>
                                <th  class="text-center"><?php echo $lang->Load_Lang_from_db(76); ?></th>
                              </tr>
                            </thead>
							            	<tbody>
                            <?php

                                    $allUser = $klient->selecLongClientHistory($userid);

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
   <script type='text/javascript'>
 
$(document).ready(function() {

     var minDate, maxDate;
    // Cusvalues
    $.fn.dataTable.ext.search.push(
        function( settings, data, dataIndex ) {
            a = new Date(document.getElementById("min").value);
            var min = a;
            console.log(min);
            b = new Date(document.getElementById("max").value);
            var max = b;
            console.log(max);
            var date = new Date( data[5] );
            console.log(date);
            if (
                ( min === null && max === null ) ||
                ( min === null && date <= max ) ||
                ( min <= date   && max === null ) ||
                ( min <= date   && date <= max )
            ) {
                return true;
            }
            return false;
        }
    );



   var table = $('#analytic_detail').DataTable({
      pageLength : 30,
      dom: 'Bfrtip',
      buttons: [
                  'copy', 'csv', 'excel', 'pdf', 'print'
              ],
      'select': {
         'style': 'single'
      },
      'order': [[1, 'asc']]
   });

    
    $('#min, #max').on('change', function () {
       
         table.draw();
     });

 
 
   
});

  </script>   



    <?php include 'template/footer.php';?>
