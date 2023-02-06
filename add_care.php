<?php
include 'template/header.php';
Session::CheckSession();
$sId =  Session::get('roleid');
if ($sId < '2') { 
  if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addUser'])) {

    $userAdd = $klient->addcaretype($_POST);
  }

  if (isset($userAdd)) {
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
                  <li class="breadcrumb-item active" aria-current="page"><?php echo $lang->Load_Lang_from_db(15); ?></li>
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
                  <form class="" action="" method="post" autocomplete="off">
                          <div class="form-group pt-3">
                            <label for="item"><?php echo $lang->Load_Lang_from_db(50); ?></label>
                            <input type="text" name="item"  class="form-control" required>
                          </div>
                    
                          <div class="form-group pt-3">
                        
                            <label for="link"><?php echo $lang->Load_Lang_from_db(51); ?></label>
                            <textarea id="link" name="link"  name="Descripcion" required></textarea>
                            
                          </div>

                          <div class="form-group pt-3">
                          <label for="note"><?php echo $lang->Load_Lang_from_db(52); ?></label>
                            <select name = 'series' id='series' class="form-control">
                            <?php
                                $allUser = $klient->  selectAllSeries();

                            if ($allUser) {
                              $i = 0;
                              foreach ($allUser as  $value) {
                      
                              echo "<option value = ".$value->id."'>".$value->name."</option>";
                            }
                          } ?> 
                          </select>  </div>
                    
                    
                          
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
          <script type="text/javascript">
    // aqui el el nombre de la Variable donde quiero el editor Ejemplo Descripcion
    $('#link').trumbowyg({
        autogrow: true
    });
</script>
  <?php
  include 'template/footer.php';

  ?>
