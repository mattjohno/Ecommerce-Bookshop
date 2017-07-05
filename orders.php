<?php
//================= DATABASE CONNECT AND HEADER =====================
require_once 'include/config.php';
include 'include/header.php';

// ======== IF CUSTOMER IS NOT LOGGED IN REDIRECT TO CATALOGUE ==========
if(!$_SESSION['cust_email']) {
    header("Location:index.php");
}

// ============== QUERY DATABASE FOR PRODUCTS IN CART ==============
$cid = ($_SESSION['cust_id']);

$sql  = "SELECT * FROM orders WHERE customerID = :cid ORDER BY datetime DESC";
 $stmt = $DB->prepare($sql);
        $stmt->bindValue(":cid", $cid); 
        $stmt->execute();

        $results = $stmt->fetchAll();  
?>
   
    <div class="container">
    <div class="clearfix"></div>
    
      <!--================================ PURCHASE HISTORY TABLE ==============================-->
      <div class="row" style="margin-top: 30px";>
      <div class="panel panel-default" style="margin-top: 30px";>
        <div class="panel-heading">
          <h3 class="panel-title" >Purchase History</h3>
        </div>
        <div class="panel-body">
         
          <div class="clearfix"></div>
          <!--============================================= PURCHASES ===================================================-->
          <?php if (count($results) > 0) { ?>
          <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered ">
              <tbody>
                <tr>
                  <th>Product Code</th>
                  <th>Title</th>
                  <th>Author</th>
                  <th>Year</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Total</th>
                  <th>Date</th>
                </tr>
                <?php foreach ($results as $res) { 
                    $quantPrice = $res['quantity'] * $res["price"];
                ?>

                <tr>
                  <td>
                    <?php echo $res["productCode"]; ?>
                  </td>
                  <td>
                    <?php echo $res["title"]; ?>
                  </td>
                  <td>
                    <?php echo $res["author"]; ?>
                  </td>
                  <td>
                    <?php echo $res["year"]; ?>
                  </td>
                  <td>
                    <?php echo $res["quantity"]; ?>
                  </td>
                  <td id="price">
                    <?php echo "$" . $res["price"]; ?>
                  </td>
                  <td id = "total">
                    <?php echo "$" . number_format((float)$quantPrice, 2);  ?>
                  </td>
                  <td>
                   <?php echo $res["datetime"]; ?>
                  </td>
                </tr>
                <?php } ?>
             </tbody>
            </table>
          </div>
          
          <!--====================================== IF CART IS EMPTY MESSAGE ===================================-->
            <?php
            for ($i = 1; $i <= $last; $i++) {
                if ($i == $pagenum) {
            ?>
            <?php echo $i ?>   
            } else {
            ?>
            <?php
                }
            }
            ?>
            <?php } else { ?>
            <div class="well well-lg">You have no purchases.</div>
            <?php } ?>
            <!--====================================== CONTINUE SHOPPING BUTTON ===================================-->
            <div id="payment">
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