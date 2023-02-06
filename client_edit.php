<?php include 'template/header.php';
Session::CheckSession();

if (isset($_GET['id'])) {
  $userid = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['id']);

}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
  $updateUser = $klient->updateLineByIdInfo($userid, $_POST);

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
                  <li class="breadcrumb-item active" aria-current="page"><?php echo $lang->Load_Lang_from_db(5); ?></li>
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
            <div class="col-lg-8 mx-auto">
              <div class="card radius-10">
                <div class="card-body">
                
                  <h5 class="mb-3"><?php echo $lang->Load_Lang_from_db(48); ?></h5>
                  
                  <h5 class="mb-0 mt-4"><?php echo $lang->Load_Lang_from_db(22); ?></h5>
                  <hr>
                  <div class="row g-3">
                  <form class="" action="" method="POST">  
                    <div class="col-6">
                       <label class="form-label"><?php echo $lang->Load_Lang_from_db(50); ?></label>
                       <input type="text" name="item" value="<?php echo $getUinfo->meno; ?>" class="form-control">
                    </div>
                    <div class="col-6">
                     <label class="form-label"><?php echo $lang->Load_Lang_from_db(92); ?></label>
                     <input type="time" id="Time_1" name="Time_1" min="06:00" max="22:00" value="<?php echo $getUinfo->Time_1; ?>"  required>
                    </div>
                 
                    <div class="col-6">
                     <label class="form-label"><?php echo $lang->Load_Lang_from_db(93); ?></label>
                     <input type="time" id="Time_2" name="Time_2" min="06:00" max="22:00" value="<?php echo $getUinfo->Time_2; ?>"  required>
                    </div>
                  <div class="form-group">
                     <button type="submit" name="update" class="btn btn-success"><?php echo $lang->Load_Lang_from_db(49); ?></button>
                  </div>

                            


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
         <script type="text/javascript">
    // aqui el el nombre de la Variable donde quiero el editor Ejemplo Descripcion
    $('#link').trumbowyg({
        autogrow: true,
        imageResize: false
    });
</script>



    <?php include 'template/footer.php';?>
