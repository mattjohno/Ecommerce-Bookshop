<?php
//================= DATABASE CONNECT AND HEADER =====================
require_once 'include/config.php';
include 'include/header.php';

// ============== QUERY DATABASE FOR PRODUCT INFO ==============
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
<!--View Content-->
<div class="container">
<div class="clearfix"></div>
   
    <div class="row" style = "margin-top: 30px;">
      <div class="panel panel-default">
        <div class="panel-heading">
          <h3 class="panel-title">View Product</h3>
        </div>
        <div class="panel-body">
          <form class="form-horizontal" name="contact_form" id="contact_form" enctype="multipart/form-data" method="post" action="process.php">
            <fieldset>
              <div class="form-group">
                <label class="col-lg-4 control-label" for="title">Title:</label>
                <div class="col-lg-5">
                  <input type="text" readonly="" placeholder="First Name" value="<?php echo $results[0]["title"] ?>" id="title" class="form-control" name="title"> 
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-4 control-label" for="author">Author:</label>
                <div class="col-lg-5">
                  <input type="text" readonly="" value="<?php echo $results[0]["author"] ?>" id="author" class="form-control" name="author">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-4 control-label" for="year">Year:</label>
                <div class="col-lg-5">
                  <input type="text" readonly="" value="<?php echo $results[0]["year"] ?>" placeholder="Year" id="year" class="form-control" name="year">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-4 control-label" for="image">Image:</label>
                <div class="col-lg-5">
                  <?php $pic = ($results[0]["imagePath"] <> "" ) ? $results[0]["imagePath"] : "no_avatar.png" ?>
                  <a href="product_pics/<?php echo $pic ?>" target="_blank"><img src="product_pics/<?php echo $pic ?>" alt="" class="btn-circle" ></a>
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-4 control-label" for="publisher">Publisher:</label>
                <div class="col-lg-5">
                  <input type="text" readonly="" value="<?php echo $results[0]["publisher"] ?>" id="publisher" class="form-control" name="publisher">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-4 control-label" for="price">Price:</label>
                <div class="col-lg-5">
                  <input type="text" readonly="" value="<?php echo "$" . $results[0]["price"] ?>" id="price" class="form-control" name="price">
                </div>
              </div>
              <div class="form-group">
                <label class="col-lg-4 control-label" for="description">Description:</label>
                <div class="col-lg-5">
                  <textarea id="description" readonly="" name="description" rows="3" class="form-control"><?php echo $results[0]["productDesc"] ?></textarea>
                </div>
              </div>
            </fieldset>
          </form>
          <div id="shopping">
          <a href="prodCatalogue.php" class="btn btn-success rounded" name="continue">Continue Shopping</a>
        </div>
        </div>
      </div>
    </div>
</div> <!--page-wrap div located in header.php closing tag-->

<!--================== FOOTER =========================-->
<?php
include 'include/footer.php';
?>