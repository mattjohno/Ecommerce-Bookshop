<?php
//================= DATABASE CONNECT AND HEADER =====================
include 'include/config.php';
include 'include/header.php';

/*================== PAGINATION CODE STARTS==================*/
if (!(isset($_GET['pagenum']))) {
    $pagenum = 1;
} else {
    $pagenum = $_GET['pagenum'];
}
$page_limit = ($_GET["show"] <> "" && is_numeric($_GET["show"])) ? $_GET["show"] : 10;
try {
    $keyword = trim($_GET["keyword"]);
    if ($keyword <> "") {
        $sql  = "SELECT * FROM products WHERE 1 AND " . " (title LIKE :keyword) ORDER BY title ";
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":keyword", $keyword . "%");
    } else {
        $sql  = "SELECT * FROM products WHERE 1 ORDER BY title ";
        $stmt = $DB->prepare($sql);
    }
    $stmt->execute();
    $total_count = count($stmt->fetchAll());
    $last        = ceil($total_count / $page_limit);
    if ($pagenum < 1) {
        $pagenum = 1;
    } elseif ($pagenum > $last) {
        $pagenum = $last;
    }
    $lower_limit = ($pagenum - 1) * $page_limit;
    $lower_limit = ($lower_limit < 0) ? 0 : $lower_limit;
    $sql2        = $sql . " limit " . ($lower_limit) . " , " . ($page_limit) . " ";
    $stmt        = $DB->prepare($sql2);
    if ($keyword <> "") {
        $stmt->bindValue(":keyword", $keyword . "%");
    }
    $stmt->execute();
    $results = $stmt->fetchAll();
}
catch (Exception $ex) {
    echo $ex->getMessage();
}
/*================== PAGINATION CODE ENDS ==================*/
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
<!--========================= PRODUCT LIST TABLE =========================-->   
      <div class="panel panel-default" style="margin-top: 30px";>
        <div class="panel-heading">
          <h3 class="panel-title" >Product List</h3>
        </div>
        <div class="panel-body">
         
         <!--============================================ SEARCH BAR ADD ITEMS ===============================================-->
         
          <div class="col-lg-12" style="padding-left: 0; padding-right: 0;">
            <form action="prodCatalogue.php" method="get">
              <div class="col-lg-6 pull-left" style="padding-left: 0;">
                <span class="pull-left" id="search-bar">
                    <label class="col-lg-12 control-label" for="keyword" style="padding-right: 0;">
                        <input type="text" value="<?php echo $_GET["keyword"]; ?>" placeholder="search by title" id="search" class="form-control" name="keyword">
                    </label>
                </span>
                <button class="btn btn-info" id="search-button" style="border-top-right-radius: 4px; border-bottom-right-radius: 4px;">search</button>
              </div>
            </form>
          </div>
          <div class="clearfix"></div>
          
          <!--============================================= ITEMS IN TABLE ===================================================-->
          <?php if (count($results) > 0) { ?>
          <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered ">
              <tbody>
                <tr>
                  <th>Image</th>
                  <th>Title</th>
                  <th>Author</th>
                  <th>Year</th>
                  <th>Price</th>
                  <th>Action </th>
                </tr>
                <?php foreach ($results as $res) { ?>
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
                    <?php echo "$" . $res["price"]; ?>
                  </td>
                  <!--================================== VIEW BUTTON =================================-->
                   <td> 
                    <a href="view.php?cid=<?php echo $res["productID"]; ?>">
                       <button class="btn btn-sm btn-info rounded">
                            <span class="glyphicon glyphicon-zoom-in" title="View"></span>
                            <span class="hidden-xs hidden-sm"> View</span>
                        </button>
                    </a>&nbsp;
                    <!--================================== ADD TO CART ==============================--> 
                    <a href="php_scripts/update_cart.php?pid=<?php echo $res["productID"]; ?>">
                        <button class="btn btn-sm btn-primary rounded">
                            <span class="glyphicon glyphicon-plus" title="Add to cart"></span>
                            <span class="hidden-xs hidden-sm"> Add to cart</span>
                        </button>
                    </a>&nbsp;
                  </td>
                </tr>
                <?php } ?>
              </tbody>
            </table>
          </div>
          
          <!--====================================== PAGINATION IMPLEMEMTED ===================================-->
          <div class="text-center">
              <div class="col-lg-12 center">
                <ul class="pagination">
                    <li>
                      <a href="prodCatalogue.php?pagenum=<?php echo $i; ?>&keyword=<?php echo $_GET["keyword"]; ?>" aria-label="Previous">
                        <span aria-hidden="true">&laquo;</span>
                      </a>
                    </li>
                    <?php
                    //Show page links
                    for ($i = 1; $i <= $last; $i++) {
                        if ($i == $pagenum) {
                    ?>
                    <li class="active">
                      <a href="javascript:void(0);">
                        <?php echo $i ?>
                      </a>
                    </li>
                    <?php
                    } else {
                    ?>
                    <li>
                        <a href="prodCatalogue.php?pagenum=<?php echo $i; ?>&keyword=<?php echo $_GET["keyword"]; ?>" 
                        class="links" onclick="displayRecords('<?php echo $page_limit; ?>', '<?php echo $i; ?>');">
                        <?php echo $i ?>
                        </a>
                    </li>
                    <?php
                        }
                    }
                    ?>
                    <li>
                      <a href="prodCatalogue.php?pagenum=<?php echo $i; ?>&keyword=<?php echo $_GET["keyword"]; ?>" aria-label="Next">
                        <span aria-hidden="true">&raquo;</span>
                      </a>
                    </li>
                </ul>
              </div>
            </div>
            <?php } else { ?>
            <div class="well well-lg">No contacts found.</div>
            <?php } ?>
        </div>
      </div>
    </div>
</div> <!--page-wrap div located in header.php closing tag-->

<!--================== FOOTER =========================-->
<?php
include 'include/footer.php';
?> 