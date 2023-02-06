<?php include 'template/header_2.php';

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
            <div class="breadcrumb-title pe-3"><?php echo $lang->Load_Lang_from_db(52); ?></div>
            <div class="ps-3">
              <nav aria-label="breadcrumb">
                <ol class="breadcrumb mb-0 p-0 align-items-center">
                  <li class="breadcrumb-item"><a href="javascript:;"><ion-icon name="home-outline"></ion-icon></a>
                  </li>
                  <li class="breadcrumb-item active" aria-current="page"><b> <?php echo $klient->selectModelCheckNameById($clientid); ?></b></li>
                </ol>
              </nav>
            </div>
		   </div>
          <!--end breadcrumb-->
              
				
				<hr/>
				<div class="card">
					<div class="card-body">
				
						<div class="table-responsive">
							<table id="example4" class="table table-striped table-bordered">
								<thead>
									<tr>
								    	<th  class="text-center">id</th>
								    	<th  class="text-center"><?php echo $lang->Load_Lang_from_db(28); ?></th>
								  		<th  class="text-center"><?php echo $lang->Load_Lang_from_db(74); ?></th>
                      <th  class="text-center"><?php echo $lang->Load_Lang_from_db(38); ?></th>
									
										
									</tr>
									
								</thead>
								<tbody class="row_position">
											<?php

											$allUser = $klient->selectAllPlanForModel($clientid);

											if ($allUser) {
												$i = 0;
												foreach ($allUser as  $value) {
												$i++;

											?>

											<tr class="text-center" id="<?php echo $value->id;?>">
											<?php if (Session::get("id") == $value->id) {
												echo " ";
											} ?>
											
											  <td><?php echo $value->id; ?></td>
												<td><?php echo $value->Position; ?></td>
												<td><?php echo $value->item; ?> </td>
                        <td><a class="btn btn-success btn-sm" href="care_edit.php?id=<?php echo $value->id;?>"><?php echo $lang->Load_Lang_from_db(48); ?></a></td>    
											
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
         
		 <script type="text/javascript">
    $(".row_position").sortable({
        delay: 150,
        stop: function() {
            var selectedData = new Array();
            $(".row_position>tr").each(function() {
                selectedData.push($(this).attr("id"));
            });
           updateOrder(selectedData);
        }
    });

    function updateOrder(aData) {
      console.log(aData);
        $.ajax({
            url: 'ajaxPost.php',
            type: 'POST',
            data: {
                allData: aData
            },
            success: function (response) {
               console.log(response);
               //Changes are saved successfully
               alert('Changes are stored successfully');
              },
              error: function(jqXHR, textStatus, errorThrown) {
              console.log(textStatus, errorThrown);
              }
        });
    }
</script>
		 <?php include 'template/footer.php';?>