<?php
//================= DATABASE CONNECT AND HEADER =====================
require_once 'include/config.php';
include 'include/header.php';

// ======= IF CUSTOMER IS LOGGED IN REDIRECT TO CATALOGUE ==========
if($_SESSION['cust_email']) {
    header("Location:prodCatalogue.php");
}
?>
<!--Edit and Update Form Content-->
    <div class="container">
    <div class="clearfix"></div>   

   <!--================= ERROR ALERT ========================-->
    <div class="row" style="margin-top: 30px;">
           <?php if ($ERROR_MSG <> "") { ?>
    <div class="rounded alert alert-dismissable alert-<?php echo $ERROR_TYPE ?>">
    <button data-dismiss="alert" class="close" type="button">×</button>
    <p>
      <?php echo $ERROR_MSG; ?>
    </p>
    </div>
    <?php } ?>
        <div class="panel panel-default">
            <div class="panel-heading">
                <h3 class="panel-title">Customer Registration Form</h3>
            </div>
                <div class="panel-body">
                   
                   <!--================================= Registration Form =================================-->
                    <form class="form-horizontal" name="contact_form" id="contact_form" enctype="multipart/form-data" method="post" action="php_scripts/processCust.php">
                        <fieldset>
                    <!--===================================== First Name ====================================-->       
                        <div class="form-group">
                            <label class="col-lg-4 control-label" for="first_name"><span class="required">*</span>First Name:</label>
                            <div class="col-lg-5">
                                <input type="text" placeholder="Peter" id="first_name" class="form-control" name="first_name" maxlength="30">
                                <span id="first_name_err" class="error"></span>
                            </div>
                        </div>
                    <!--===================================== Last Name ====================================-->      
                        <div class="form-group">
                            <label class="col-lg-4 control-label" for="last_name"><span class="required">*</span>Last Name:</label>
                            <div class="col-lg-5">
                                <input type="text" placeholder="Sherman" id="last_name" class="form-control" name="last_name" maxlength="30">
                                <span id="last_name_err" class="error"></span> 
                            </div>
                        </div>
                    <!--====================================== Address =====================================-->    
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="address"><span class="required">*</span>Address:</label>
                        <div class="col-lg-5">
                            <input type="text" placeholder="42 Wallaby Way" id="address" class="form-control" name="address" maxlength="30">
                            <span id="address_err" class="error"></span> 
                        </div>
                    </div>
                    <!--======================================== City ======================================-->  
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="city"><span class="required">*</span>City:</label>
                        <div class="col-lg-5">
                            <input type="text" placeholder="Sydney" id="city" class="form-control" name="city" maxlength="120">
                            <span id="city_err" class="error"></span> 
                        </div>
                    </div>
                    <!--======================================= Postcode =====================================--> 
                      <div class="form-group">
                        <label class="col-lg-4 control-label" for="postcode"><span class="required">*</span>Postcode:</label>
                        <div class="col-lg-5">
                            <input type="text" placeholder="2000" id="postcode" class="form-control" name="postcode" maxlength="4">
                            <span id="postcode_err" class="error"></span> 
                        </div>
                    </div>
                    <!--======================================= Phone =====================================-->  
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="phone"><span class="required">*</span>Phone:</label>
                        <div class="col-lg-5">
                            <input type="text" placeholder="Contact Number" id="phone" class="form-control" name="phone" maxlength="10">
                            <span id="phone_err" class="error"></span>
                            <span class="help-block">Maximum of 10 digits only and only numbers.</span>
                        </div>
                    </div>
                    <!--===================================== VIP Number ===================================-->               
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="vip_num">VIP Number:</label>
                        <div class="col-lg-5">
                            <input type="text" id="vip_num" class="form-control file" name="vip_num">
                            <span id="profile_pic_err" class="error"></span>
                        </div>
                    </div>
                    <!--======================================== Email =====================================--> 
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="email_id"><span class="required">*</span>Email:</label>
                        <div class="col-lg-5">
                            <input type="text" placeholder="peter@sherman.com" id="email_id" class="form-control" name="email_id" maxlength="120">
                            <span id="email_id_err" class="error"></span>
                        </div>
                    </div>
                    <!--======================================= Password ===================================--> 
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="password"><span class="required">*</span>Password:</label>
                        <div class="col-lg-5">
                            <input type="password" placeholder="" id="password" class="form-control" name="password" maxlength="10">
                            <span id="password_id_err" class="error"></span>
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="password2"><span class="required">*</span>Confirm Password:</label>
                        <div class="col-lg-5">
                            <input type="password" placeholder="" id="password2" class="form-control" name="password2" maxlength="10">
                            <!--<span id="password_id_err" class="error"></span>-->
                            <span class="help-block">Must contain 6 to 8 characters</span>
                        </div>
                    </div>                 
                    <div class="form-group">
                        <div class="col-lg-5 col-lg-offset-4">
                            <button class="btn btn-primary rounded" onsubmit="validateForm()"; type="submit">Submit</button>
                        </div>
                    </div>
                    </fieldset>
                </form>
            </div>
        </div>
    </div>
</div> <!--page-wrap div located in header.php closing tag-->


<!--=============== ERROR MESSAGE FUNCTION ================-->
<script type="text/javascript">
$(document).ready(function() {
  // the fade out effect on hover
  $('.error').hover(function() {
    $(this).fadeOut(200);
  });
  $("#contact_form").submit(function() {
    $('.error').fadeOut(200);
    if (!validateForm()) {
      // go to the top of form first
      $(window).scrollTop($("#contact_form").offset().top);
      return false;
    }
    return true;
  });
});

//--=============== VALIDATION FUNCTION ================-
function validateForm() {
  var errCnt = 0;
  var first_name = $.trim($("#first_name").val());
  var last_name = $.trim($("#last_name").val());
  var address = $.trim($("#address").val());
  var city = $.trim($("#city").val());
  var postcode = $.trim($("#postcode").val());
  var phone = $.trim($("#phone").val());    
  var email_id = $.trim($("#email_id").val());  
  var password = $.trim($("#password").val());
  var password2 = $.trim($("#password2").val());

//============== Validate First Name ====================
    
  if (first_name == "") {
    $("#first_name_err").html("Enter your first name.");
    $('#first_name_err').fadeIn("fast");
    errCnt++;
  } else if (first_name.length <= 2) {
    $("#first_name_err").html("Enter at least 3 letter.");
    $('#first_name_err').fadeIn("fast");
    errCnt++;
  }

//============== Validate Last Name ====================

  if (last_name == "") {
    $("#last_name_err").html("Enter your last name.");
    $('#last_name_err').fadeIn("fast");
    errCnt++;
  } else if (last_name.length <= 2) {
    $("#last_name_err").html("Enter at least 3 letter.");
    $('#last_name_err').fadeIn("fast");
    errCnt++;
  }
    
//============== Validate Address =====================
    
  if (address == "") {
    $("#address_err").html("Enter your address.");
    $('#address_err').fadeIn("fast");
    errCnt++;
  } else if (address.length <= 2) {
    $("#address_err").html("Enter at least 3 letter.");
    $('#address_err').fadeIn("fast");
    errCnt++;
  }
  
//================ Validate City ========================
    
  if (city == "") {
    $("#city_err").html("Enter your city.");
    $('#city_err').fadeIn("fast");
    errCnt++;
  } else if (city.length <= 1) {
    $("#city_err").html("Enter at least 2 letter.");
    $('#city_err').fadeIn("fast");
    errCnt++;
  }
    
//=============== Validate Postcode ==================== 
    
  if (postcode == "") {
    $("#postcode_err").html("Enter your postcode.");
    $('#postcode_err').fadeIn("fast");
    errCnt++;
  } else if (postcode.length <= 3) {
    $("#postcode_err").html("Enter at least 4 numbers.");
    $('#postcode_err').fadeIn("fast");
    errCnt++;
  } else if (!$.isNumeric(postcode)) {
    $("#postcode_err").html("Must be digits only.");
    $('#postcode_err').fadeIn("fast");
    errCnt++;
  }    
    
if (password != password2) {
    $('#password_id_err').html("Your passwords do not match");
    $('#password_id_err').fadeIn("fast");
    errCnt++;
} else if (password.length < 6 || password.length > 8 ) {
    $('#password_id_err').html("Enter between 6  to 8 letters.");
    $('#password_id_err').fadeIn("fast");
    errCnt++;
  }

//============== Validate Phone ====================    
    
  if (phone == "") {
    $("#phone_err").html("Enter phone number.");
    $('#phone_err').fadeIn("fast");
    errCnt++;
  } else if (phone.length <= 9 || phone.length > 10) {
    $("#phone_err").html("Enter 10 digits only.");
    $('#phone_err').fadeIn("fast");
    errCnt++;
  } else if (!$.isNumeric(phone)) {
    $("#phone_err").html("Must be digits only.");
    $('#phone_err').fadeIn("fast");
    errCnt++;
  }    
    
//============== Validate Email ====================
    
  if (!isValidEmail(email_id)) {
    $("#email_id_err").html("Enter valid email.");
    $('#email_id_err').fadeIn("fast");
    errCnt++;
  }
  if (errCnt > 0) return false;
  else return true;
}
    

function isValidEmail(email) {
  var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
  return regex.test(email);
}
        
//========== LETTERS ONLY FUNCTION ================
    
$("#first_name, #middle_name, #last_name, #city").alphanum({
    allow              : 'àâäæ',
    allowNumeric       : false,
    // a-z A-Z
    allowLatin         : true, 
    // eg é, Á, Arabic, Chinese etc
    allowOtherCharSets : true, 
});
</script>

<!--======= FOOTER =========================-->
<?php
    include 'include/footer.php';
?>