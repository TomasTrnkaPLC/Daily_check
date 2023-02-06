<?php include 'template/header.php';
Session::CheckSession();

if (isset($_GET['id'])) {
  $check_id = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['id']);
  $line_id = preg_replace('/[^a-zA-Z0-9-]/', '', (int)$_GET['line']);

}


if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update'])) {
  $updateUser = $klient->updatecareforklient($_POST);

}
if (isset($updateUser)) {
  echo $updateUser;
}


 ?>
<style>

.onoffswitch {
    position: relative;
    width: 100px;
    -webkit-user-select: none;
    -moz-user-select: none;
    -ms-user-select: none;
  display: inline-block;
}

.onoffswitch-checkbox {
    display: none;
}

.onoffswitch-label {
    display: block;
    overflow: hidden;
    cursor: pointer;
    border: 0px solid #999999;
    border-radius: 0px;
}

.onoffswitch-inner {
    width: 200%;
    margin-left: -100%;
    -moz-transition: margin 0.3s ease-in 0s;
    -webkit-transition: margin 0.3s ease-in 0s;
    -o-transition: margin 0.3s ease-in 0s;
    transition: margin 0.3s ease-in 0s;
}

.onoffswitch-inner > div {
    float: left;
    position: relative;
    width: 50%;
    height: 60px;
    padding: 0;
    line-height: 60px;
    font-size: 40px;
    color: white;
    font-family: Trebuchet, Arial, sans-serif;
    font-weight: bold;
    -moz-box-sizing: border-box;
    -webkit-box-sizing: border-box;
    box-sizing: border-box;
}

.onoffswitch-inner .onoffswitch-active {
    padding-left: 15px;
    background-color: #green;
    color: #FFFFFF;
}

.onoffswitch-inner .onoffswitch-inactive {
    padding-right: 15px;
    background-color: red;
    color: #FFFFFF;
    text-align: right;
}

.onoffswitch-switch {
    
    margin: 0px;
    text-align: center;
    border: 0px solid #999999;
    border-radius: 0px;
   
    top: 0;
    bottom: 0;
}

.onoffswitch-active .onoffswitch-switch {
    background: green;
    left: 0;
}

.onoffswitch-inactive .onoffswitch-switch {
    background: red;
    right: 0;
}

.onoffswitch-active .onoffswitch-switch:before {
    content: " ";
    position: absolute;
    top: 0;
    left: 40px;
    border-style: solid;
    border-color: #27A1CA transparent transparent #27A1CA;
    border-width: 15px 10px;
}

.onoffswitch-inactive .onoffswitch-switch:before {
    content: " ";
    position: absolute;
    top: 0;
    right: 40px;
    border-style: solid;
    border-color: transparent #A1A1A1 #A1A1A1 transparent;
    border-width: 15px 10px;
}

.onoffswitch-checkbox:checked + .onoffswitch-label .onoffswitch-inner {
    margin-left: 0;
}
</style>
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
    
    $getCinfo = $care->getCheckInfoById($check_id);
 
    $getRinfo = $care->getCheckInfoIfCareExist($check_id, $line_id);
    var_dump ($getRinfo);
    if ($getCinfo) {
    ?>
      <div class="row">
     
             
                      <div class="col-md-12"> 
                      
                          <h5 class="mb-0 mt-4"><?php echo $lang->Load_Lang_from_db(22); ?></h5>
                          <hr>
                          <form class="" action="" method="POST">  
                          <?php    if ($getRinfo == 'Hotovo'){
                                                echo $lang->Load_Lang_from_db(71); ?>
                                  
                                                <input type="text" name="item" value="<?php echo $care->care_name($getCinfo->care_type); ?>" class="form-control">
                                                <input type="text" name="id" value="<?php echo $check_id; ?>" hidden>
                                                <input type="text" name="line_id" value="<?php echo $line_id; ?>" hidden>
                                                <input type="text" name="position" value="<?php echo $getCinfo->care_type; ?>" hidden>
                                                <label class="form-label"><?php echo $lang->Load_Lang_from_db(70); ?></label>
                                                <input type="text" name="link" value="<?php echo $getCinfo->care_time; ?>" class="form-control">
                                                <label class="form-label"><?php echo $lang->Load_Lang_from_db(75); ?></label>
                                                <input type="text" name="link" value="<?php echo $getCinfo->care_done; ?>" class="form-control">
                                                <h3>
                                                <label class="form-label"><?php echo $lang->Load_Lang_from_db(51); ?></label>
                                                <?php echo $care->care_name_description($getCinfo->care_type); ?>
                                                </h3>
                                                <input type="text" name="link" value="<?php echo $care->care_name_description($getCinfo->care_type); ?>" class="form-control" disabled="disabled" hidden>
                                            
                                                <label class="form-label"><?php echo $lang->Load_Lang_from_db(52); ?></label>
                                                <input type="text" id="note" name="note" value="<?php echo $getCinfo->note; ?>" class="form-control">
                                                </br>
                                                <label class="form-label"><?php echo $lang->Load_Lang_from_db(77); ?></label>
                                                <?php if ($getCinfo->result_switch == 'on'){
                                                      echo " <input type='text' value='".$lang->Load_Lang_from_db(80)."' class='form-control'>";
                                                    } elseif($value->result_switch == 'off'){
                                                        echo " <input type='text' value='".$lang->Load_Lang_from_db(81)."' class='form-control'>";
                                                    }
                                                }else{ ?>


                                                                <label class="form-label"><?php echo $lang->Load_Lang_from_db(50); ?></label>
                                                                <input type="text" name="item" value="<?php echo $getCinfo->item; ?>" class="form-control" disabled>
                                                         
                                                            
                                                                <input type="text" name="id" value="<?php echo $check_id; ?>" hidden>
                                                                <input type="text" name="line_id" value="<?php echo $line_id; ?>" hidden>
                                                                <input type="text" name="position" value="<?php echo $getCinfo->Position; ?>" hidden>
                                                                <h3>
                                                                <label class="form-label"><?php echo $lang->Load_Lang_from_db(51); ?></label>
                                                               
                                                                </h3>
                                                              
                                                                <textarea id="link" name="link"  name="Descripcion"  required><?php echo $getCinfo->link; ?> ></textarea>
                                                                <label class="form-label"><?php echo $lang->Load_Lang_from_db(96); ?></label>
                                                                <input type="text" id="note" name="note" value="<?php echo $getCinfo->note; ?>" class="form-control">
                                                                </br>
                                                                <input type="checkbox" class="onoffswitch-checkbox" id="result_switch" name="result_switch">
                                                                        <label class="onoffswitch-label" for="result_switch">
                                                                            <div class="onoffswitch-inner">
                                                                                <div class="onoffswitch-active">
                                                                                    <div class="onoffswitch-switch"><?php echo $lang->Load_Lang_from_db(80); ?></div>
                                                                                </div>
                                                                                <div class="onoffswitch-inactive">
                                                                                    <div class="onoffswitch-switch"><?php echo $lang->Load_Lang_from_db(81); ?></div>
                                                                                </div>
                                                                            </div>
                                                                        </label>

                              <input type="text" name="user_id" value="<?php echo Session::get('id'); ?>" hidden>
                       <?php    if ($getRinfo == 'Hotovo'){
                                    echo $lang->Load_Lang_from_db(71); 
                                }else{ ?>
                                 <button type="submit" name="update" class="btn btn-success"><?php echo $lang->Load_Lang_from_db(49); ?></button>
                        <?php } ?>
                  </div>
                  <?php } ?>
                      
                    
          </form>
                              <?php }else{


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
        autogrow: true
    });
</script>
    <?php include 'template/footer.php';?>
