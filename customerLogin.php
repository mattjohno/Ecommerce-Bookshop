<?php
//================= DATABASE CONNECT AND HEADER =====================
require_once 'include/config.php';
include 'include/header.php';

// ======= IF CUSTOMER IS LOGGED IN REDIRECT TO CATALOGUE ==========
if($_SESSION['cust_email']) {
    header("Location:prodCatalogue.php");
}
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
            <h3 class="panel-title">Customer Login</h3>
        </div>
            <div class="panel-body">
                <form class="form-horizontal" name="cust_login_form" id="cust_login_form" enctype="multipart/form-data" method="post" action="php_scripts/verify.php">
                    <fieldset>
               <!--===================================== Email ====================================-->       
               <div class="form-group">
                    <label class="col-lg-4 control-label" for="cust_email">Email:</label>
                    <div class="col-lg-5">
                        <input type="text" id="cust_email" class="form-control" name="cust_email" maxlength="255" required>
                        <span id="product_err" class="error"></span> 
                    </div>
                </div>
                <!--======================================== Password ======================================-->  
                <div class="form-group">
                    <label class="col-lg-4 control-label" for="cust_pass">Password:</label>
                    <div class="col-lg-5">
                        <input type="password" id="cust_pass" class="form-control" name="cust_pass" maxlength="15" required>
                        <span id="author_err" class="error"></span> 
                    </div>
                </div>
                <!--======================================== Submit =====================================-->                                                                
                <div class="form-group">
                    <div class="col-lg-5 col-lg-offset-4">
                        <button class="btn btn-primary rounded" name="cust_login" type="submit">Login</button>
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