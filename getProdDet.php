<?php
//================= DATABASE CONNECT AND HEADER =====================
require_once 'include/config.php';
include 'include/header.php';

//=== IF SESSION (LOGIN) NOT CREATED REDIRECT TO adminLogin.php ===
if(!$_SESSION['admin_email']) {
    header("Location:adminLogin.php");
}

// ============== QUERY DATABASE FOR PRODUCTS ==============
try {
    $sql  = "SELECT * FROM products WHERE 1 AND productID = :cid";
    $stmt = $DB->prepare($sql);
    $stmt->bindValue(":cid", intval($_GET["cid"]));
    $stmt->execute();
    $results = $stmt->fetchAll();
}
catch (Exception $ex) {
    echo $ex->getMessage();
}
?>

<div class="container">
<div class="clearfix"></div>

<!--Edit and Update Form Content-->   
    <div class="row">
        <div class="panel panel-default" style="margin-top: 30px">
            <div class="panel-heading">
                <h3 class="panel-title"><?php echo ($_GET["m"] == "update") ? "Edit" : "Add"; ?> Product</h3>
            </div>
                <div class="panel-body">
                    <form class="form-horizontal" name="contact_form" id="contact_form" enctype="multipart/form-data" method="post" action="php_scripts/processProd.php">
                        <input type="hidden" name="mode" value="<?php echo ($_GET["m"] == "update") ? "update_old" : "add_new"; ?>" >
                        <input type="hidden" name="old_pic" value="<?php echo $results[0]["imagePath"] ?>" >
                        <input type="hidden" name="cid" value="<?php echo intval($results[0]["productID"]); ?>" >
                        <input type="hidden" name="pagenum" value="<?php echo $_GET["pagenum"]; ?>" >
                        <fieldset>
                   <!--===================================== Product Name ====================================-->       
                   <div class="form-group">
                        <label class="col-lg-4 control-label" for="product_name"><span class="required">*</span>Product Code:</label>
                        <div class="col-lg-5">
                            <input type="text" value="<?php echo $results[0]["productCode"] ?>" placeholder="PDX001" id="product_code" class="form-control" name="product_code" maxlength="255">
                            <span id="product_err" class="error"></span> 
                        </div>
                    </div>
                    <!--======================================== Authour ======================================-->  
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="author"><span class="required">*</span>Author:</label>
                        <div class="col-lg-5">
                            <input type="text" value="<?php echo $results[0]["author"] ?>" placeholder="Herman Melville" id="author" class="form-control" name="author" maxlength="120">
                            <span id="author_err" class="error"></span> 
                        </div>
                    </div>
                    <!--======================================= Title =====================================--> 
                      <div class="form-group">
                        <label class="col-lg-4 control-label" for="title"><span class="required">*</span>Title:</label>
                        <div class="col-lg-5">
                            <input type="text" value="<?php echo $results[0]["title"] ?>" placeholder="Mody Dick" id="title" class="form-control" name="title" maxlength="255">
                            <span id="title_err" class="error"></span> 
                        </div>
                    </div>
                    <!--======================================= Year =====================================-->  
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="year">Year:</label>
                        <div class="col-lg-5">
                            <input type="text" value="<?php echo $results[0]["year"] ?>" placeholder="1851" id="year" class="form-control" name="year" maxlength="4">
                            <span id="year_err" class="error"></span>
                        </div>
                    </div>
                    <!--===================================== Publisher ===================================-->               
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="publisher">Publisher:</label>
                        <div class="col-lg-5">
                            <input type="text" value="<?php echo $results[0]["publisher"] ?>" placeholder="Harper & Brothers" id="publisher" class="form-control file" name="publisher">
                            <span id="publisher_err" class="error"></span>
                        </div>
                    </div>    
                    <!--======================================= Price ===================================--> 
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="price"><span class="required">*</span>Price:</label>
                        <div class="col-lg-5">
                            <input type="text" value="<?php echo $results[0]["price"] ?>" placeholder="" id="price" class="form-control" name="price" maxlength="8">
                            <span id="price_err" class="error"></span>
                        </div>
                    </div>
                    <!--======================================= Image ===================================-->
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="image">Image:</label>
                        <div class="col-lg-5">
                            <input type="file" id="image" class="form-control file" name="image">
                            <span id="image_pic_err" class="error"></span>
                            <span class="help-block">Must be jpg, jpeg, png, gif, bmp image only.</span>
                        </div>
                    </div>
                    <?php if ($_GET["m"] == "update") { ?>
                        <div class="form-group">
                        <div class="col-lg-1 col-lg-offset-4">
                            <?php $pic = ($results[0]["imagePath"] <> "" ) ? $results[0]["imagePath"] : "no_avatar.png" ?>
                            <a href="product_pics/<?php echo $pic ?>" target="_blank"><img src="product_pics/<?php echo $pic ?>" alt="" width="100" height="100" class="thumbnail" ></a>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <!--======================================== Description =====================================--> 
                    <div class="form-group">
                        <label class="col-lg-4 control-label" for="description"><span class="required">*</span>Description:</label>
                        <div class="col-lg-5">
                            <input type="textarea" value="<?php echo $results[0]["productDesc"] ?>" placeholder="The Whale is a novel by American..." id="description" class="form-control" name="description" maxlength="500">
                            <span id="desc_err" class="error"></span>
                        </div>
                    </div>
                    <!--======================================== Submit =====================================-->                                                     
                    <div class="form-group">
                        <div class="col-lg-5 col-lg-offset-4">
                            <button class="btn btn-primary rounded" type="submit">Submit</button>
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
  var productCode = $.trim($("#product_code").val());
  var author = $.trim($("#author").val());
  var title = $.trim($("#title").val());
  var year = $.trim($("#year").val());
  var publisher = $.trim($("#publisher").val());
  var price = $.trim($("#price").val());
  var image = $.trim($("#image").val());
    
  
//============== Validate Product Code ====================
  if (productCode == "") {
    $("#product_err").html("Enter unique product code.");
    $('#product_err').fadeIn("fast");
    errCnt++;
  } else if (productCode.length <= 2) {
    $("#product_err").html("Enter at least 3 letter.");
    $('#product_err').fadeIn("fast");
    errCnt++;
  }
//============== Validate Author ====================
  if (author == "") {
    $("#author_err").html("Enter the authors name.");
    $('#author_err').fadeIn("fast");
    errCnt++;
  } else if (author.length <= 2) {
    $("#author_err").html("Enter at least 3 letter.");
    $('#author_err').fadeIn("fast");
    errCnt++;
  }
//============== Validate Title ====================
  if (title == "") {
    $("#title_err").html("Enter the books title.");
    $('#title_err').fadeIn("fast");
    errCnt++;
  } else if (title.length <= 2) {
    $("#title_err").html("Enter at least 3 letter.");
    $('#title_err').fadeIn("fast");
    errCnt++;
  }
//============== Validate Year ====================
  if (year == "") {
    $("#year_err").html("Enter year published.");
    $('#year_err').fadeIn("fast");
    errCnt++;
  } else if (year.length != 4) {
    $("#year_err").html("Enter 4 digits only.");
    $('#year_err').fadeIn("fast");
    errCnt++;
  } else if (!$.isNumeric(year)) {
    $("#year_err").html("Must be digits only.");
    $('#year_err').fadeIn("fast");
    errCnt++;
  }
//============== Validate Publisher ====================
  if (publisher == "") {
    $("#publisher_err").html("Enter publishers name.");
    $('#publisher_err').fadeIn("fast");
    errCnt++;
  } else if (publisher.length <= 2) {
    $("#publisher_err").html("Enter at least 3 letter.");
    $('#publisher_err').fadeIn("fast");
    errCnt++;
  }
//============== Validate Price ====================
  if (price == "") {
    $("#price_err").html("Enter the price of the product.");
    $('#price_err').fadeIn("fast");
    errCnt++;
  } else if (!$.isNumeric(price)) {
    $("#price_err").html("Must be digits only.");
    $('#price_err').fadeIn("fast");
    errCnt++;
  }
  if (image.length > 0) {
    var exts = ['jpg', 'jpeg', 'png', 'gif', 'bmp'];
    var get_ext = image.split('.');
    get_ext = get_ext.reverse();
    if ($.inArray(get_ext[0].toLowerCase(), exts) <= -1) {
      $("#image_pic_err").html("Must be jpg, jpeg, png, gif, bmp image only..");
      $('#image_pic_err').fadeIn("fast");
    }
  }    
//============== Check for no errors ====================    
  if (errCnt > 0) return false;
  else return true;
}
</script>

<!--================== FOOTER =========================-->
<?php
    include 'include/footer.php';
?>