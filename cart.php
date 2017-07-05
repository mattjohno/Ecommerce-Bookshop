<?php
//================= DATABASE CONNECT AND HEADER =====================
require_once 'include/config.php';
include 'include/header.php';

// ======== IF CUSTOMER IS NOT LOGGED IN REDIRECT TO INDEX ==========
if(!$_SESSION['cust_email']) {
    header("Location:index.php");
}

// ============== QUERY DATABASE FOR PRODUCTS IN CART ==============
$cid = ($_SESSION['cust_id']);
$sql  = "SELECT * FROM products JOIN cart ON products.productID = cart.productID WHERE cart.customerID = :cid";
 $stmt = $DB->prepare($sql);
        $stmt->bindValue(":cid", $cid); 
        $stmt->execute();

        $results = $stmt->fetchAll();  
?>
    <div class="container">
    <div class="clearfix"></div>
    
    <!--================= ERROR ALERT ========================-->
    <div class="row" style="margin-top: 30px";>
      <?php if ($ERROR_MSG <> "") { ?>
      <div class="rounded alert alert-dismissable alert-<?php echo $ERROR_TYPE ?>">
        <button data-dismiss="alert" class="close" type="button">×</button>
        <p>
          <?php echo $ERROR_MSG; ?>
        </p>
      </div>
      <?php } ?>
      <!--================================= SHOPPING CART=================================-->
      <div class="panel panel-default" style="margin-top: 30px";>
        <div class="panel-heading">
          <h3 class="panel-title" >Your Shopping Cart</h3>
        </div>
        <div class="panel-body">
          <div class="clearfix"></div>
          
          <!--============================================= ITEMS IN TABLE ===================================================-->
          <?php if (count($results) > 0) {         
            $total = 0;                     //counter variable for total price
            ?>
            
          <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered ">
              <tbody>
                <tr>
                  <th>Image</th>
                  <th>Title</th>
                  <th>Author</th>
                  <th>Year</th>
                  <th>Quantity</th>
                  <th>Price</th>
                  <th>Total</th>
                  <th>Action</th>
                </tr>
                <?php foreach ($results as $res) { 
                    $quantPrice = $res['quantity'] * $res["price"];             // Total item price
                    $total = $total + $quantPrice;                              // Total cart price
                ?>
                <tr>
                  <td style="text-align: center;">
                    <?php $pic = ($res["imagePath"] <> "" ) ? $res["imagePath"] : "no_avatar.png" ?>
                    <a href="product_pics/<?php echo $pic ?>" target="_blank" ><img src="product_pics/<?php echo $pic ?>" alt="" class="btn-circle"></a>
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
                  <!--================================== QUANTITY SECTION =================================--> 
                   <form id="quant_form" name="quant_form" enctype="multipart/form-data" method="get" action="php_scripts/quantity.php">          
                        <input type="text" id="quantity" name="quantity" value="<?php echo $res["quantity"]?>" 
                        placeholder="1" class="form-control" style="width: 51px; margin-bottom: 5px;" maxlength="1" onchange="total();" />
                        <input type="hidden" id="cartID" name="cartID" value="<?php echo $res["cartID"]?>" />
                     <button class="btn btn-primary rounded btn-md glyphicon glyphicon-refresh" name="quant_button" type="submit"></button>
                    </form> 
                  </td>
                  <td id="price">
                    <?php echo "$" . $res["price"]; ?>
                  </td>
                  <td id = "total">
                    <?php echo "$" . number_format((float)$quantPrice, 2);  ?>
                  </td>

                  <td>
                  <!--================================== VIEW BUTTON =================================--> 
                    <a href="view.php?cid=<?php echo $res["productID"]; ?>">
                       <button class="btn btn-sm btn-info rounded">
                            <span class="glyphicon glyphicon-zoom-in" title="View"></span>
                            <span class="hidden-xs hidden-sm"> View</span>
                        </button>
                    </a>&nbsp;
                    <!--================================== REMOVE FROM TO CART ==============================--> 
                    <a href="php_scripts/delete_cart.php?pid=<?php echo $res["productID"]; ?>">
                        <button class="btn btn-sm btn-danger rounded" onclick="return confirm('Are you sure?')">
                            <span class="glyphicon glyphicon-minus" title="Remove from cart"></span>
                            <span class="hidden-xs hidden-sm"> Remove from cart</span>
                        </button>
                    </a>&nbsp;
                  </td>
                </tr>
                <?php } ?>
                <!--================================== TOTAL $ ROW ==============================-->
                <tr>
                    <td><strong>Total</strong></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td><?php echo "$" . number_format((float)$total, 2); ?></td>
                    <td></td>
                </tr>
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
            <div class="well well-lg">You have no items in your cart.</div>
            <?php } ?>
        <!--====================================== SHOPPING AND PAYMENT BUTTONS ===================================-->
        <div id="payment">
            <a href="prodCatalogue.php" class="btn btn-success rounded" name="continue">Continue Shopping</a>
            <a href="php_scripts/processOrder.php" class="btn btn-primary rounded" name="payment" onclick="return confirm('Confirm payment of <?php echo number_format((float)$total, 2); ?>?')">Cash on delivery</a>
        </div>
        </div>
      </div>
    </div>
</div> <!--page-wrap div located in header.php closing tag-->

<!--================== FOOTER =========================-->
<?php
include 'include/footer.php';
?> 