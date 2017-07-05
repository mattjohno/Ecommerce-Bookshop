<?php
//================= DATABASE CONNECT AND HEADER =====================
require_once 'include/config.php';
include 'include/header.php';
?>

<div class="container">
<div class="clearfix"></div>
<!--=========================ERROR MESSAGE =========================-->
<div class="row" style="margin-top: 30px";>
    <?php if ($ERROR_MSG <> "") { ?>
    <div class="rounded alert alert-dismissable alert-<?php echo $ERROR_TYPE ?>">
    <button data-dismiss="alert" class="close" type="button">×</button>
    <p>
      <?php echo $ERROR_MSG; ?>
    </p>
    </div>
    <?php } ?>
<!--=======================ADMIN LOGIN MESSAGE ===================-->       
    <div class="panel panel-default" style="margin-top: 30px">
        <div class="panel-heading">
            <h3 class="panel-title">Admin Login</h3>
        </div>
            <div class="panel-body">
                <form class="form-horizontal" name="admin_form" id="admin_form" enctype="multipart/form-data" method="post" action="php_scripts/verify.php">
                    <fieldset>
               <!--===================================== Email ====================================-->       
               <div class="form-group">
                    <label class="col-lg-4 control-label" for="admin_email">Email:</label>
                    <div class="col-lg-5">
                        <input type="text" id="admin_email" class="form-control" name="admin_email" maxlength="255" autocomplete="off" required> 
                    </div>
                </div>
                <!--======================================== Password ======================================-->  
                <div class="form-group">
                    <label class="col-lg-4 control-label" for="admin_password">Password:</label>
                    <div class="col-lg-5">
                        <input type="password" id="admin_password" class="form-control" name="admin_password" maxlength="120" autocomplete="off" required>
                    </div>
                </div>
                <!--======================================== Submit =====================================-->                                                                
                <div class="form-group">
                    <div class="col-lg-5 col-lg-offset-4">
                        <button class="btn btn-primary rounded" name="admin_login" type="submit">Login</button>
                    </div>
                </div>
                </fieldset>
            </form>
        </div>
    </div>
</div>

<!--================== FOOTER =========================-->
</div>
<?php
include 'include/footer.php';
?> 