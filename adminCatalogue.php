<?php
//================= DATABASE CONNECT AND HEADER =====================
require_once 'include/config.php';
include 'include/header.php';

//=== IF SESSION (LOGIN) NOT CREATED REDIRECT TO adminLogin.php ===
if(!$_SESSION['admin_email']) {
    header("Location:adminLogin.php");
}

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
    <div class="row" style="margin-top: 30px";>
      <?php if ($ERROR_MSG <> "") { ?>
      <div class="rounded alert alert-dismissable alert-<?php echo $ERROR_TYPE ?>">
        <button data-dismiss="alert" class="close" type="button">×</button>
        <p>
          <?php echo $ERROR_MSG; ?>
        </p>
      </div>
      <?php } ?>
      <div class="panel panel-default" style="margin-top: 30px";>
        <div class="panel-heading">
          <h3 class="panel-title" >Product List</h3>
        </div>
        <div class="panel-body">
         
         <!--============================================ SEARCH BAR ADD ITEMS ===============================================-->
         
          <div class="col-lg-12" style="padding-left: 0; padding-right: 0;">
            <form action="adminCatalogue.php" method="get">
              <div class="col-lg-6 pull-left" style="padding-left: 0;">
                <span class="pull-left" id="search-bar">
                    <label class="col-lg-12 control-label" for="keyword" style="padding-right: 0;">
                        <input type="text" value="<?php echo $_GET["keyword"]; ?>" placeholder="search by title" id="search" class="form-control" name="keyword">
                    </label>
                </span>
                <button class="btn btn-info" id="search-button" style="border-top-right-radius: 4px; border-bottom-right-radius: 4px;">search</button>
              </div>
            </form>
            <div class="pull-right"><a href="getProdDet.php" id="addcontact"><button class="btn btn-success rounded"><span class="glyphicon glyphicon-plus"></span> Add New Product</button></a></div>
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
                  <th class="hidden-xs hidden-sm">Year</th>
                  <th class="hidden-xs hidden-sm">Price</th>
                  <th>Publisher</th>
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
                  <td class="hidden-xs hidden-sm">
                    <?php echo $res["year"]; ?>
                  </td>
                  <td class="hidden-xs hidden-sm">
                    <?php echo "$" . $res["price"]; ?>
                  </td>
                  <td class="hidden-xs hidden-sm">
                    <?php echo $res["publisher"]; ?>
                  </td>
                  <td>
                  
                  <!--================================== VIEW BUTTON =================================--> 
                    <a href="view.php?cid=<?php echo $res["productID"]; ?>">
                       <button class="btn btn-sm btn-info rounded">
                            <span class="glyphicon glyphicon-zoom-in" title="View"></span>
                            <span class="hidden-xs hidden-sm"> View</span>
                        </button>
                    </a>&nbsp;
                    
                    <!--================================== UPDATE BUTTON =================================--> 
                    <a href="getProdDet.php?m=update&cid=<?php echo $res["productID"]; ?>&pagenum=<?php echo $_GET["pagenum"]; ?>">
                        <button class="btn btn-sm btn-warning rounded">
                            <span class="glyphicon glyphicon-edit" title="Edit"></span>
                            <span class="hidden-xs hidden-sm"> Edit</span>
                        </button>
                    </a>&nbsp;
                    
                    <!--================================== DELETE BUTTON =================================--> 
                    <a href="php_scripts/processProd.php?mode=delete&cid=<?php echo $res["productID"]; ?>&keyword=<?php echo $_GET["keyword"]; ?>&pagenum=<?php echo $_GET["pagenum"]; ?>" onclick="return confirm('Are you sure?')">
                        <button class="btn btn-sm btn-danger rounded">
                            <span class="glyphicon glyphicon-remove-circle" title="Delete"></span>
                            <span class="hidden-xs hidden-sm"> Delete</span>
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
                      <a href="adminCatalogue.php?pagenum=<?php echo $i; ?>&keyword=<?php echo $_GET["keyword"]; ?>" aria-label="Previous">
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
                        <a href="adminCatalogue.php?pagenum=<?php echo $i; ?>&keyword=<?php echo $_GET["keyword"]; ?>" 
                        class="links" onclick="displayRecords('<?php echo $page_limit; ?>', '<?php echo $i; ?>');">
                        <?php echo $i ?>
                        </a>
                    </li>
                    <?php
                        }
                    }
                    ?>
                    <li>
                      <a href="adminCatalogue.php?pagenum=<?php echo $i; ?>&keyword=<?php echo $_GET["keyword"]; ?>" aria-label="Next">
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

<!--================== FOOTER =========================-->        
</div> <!--page-wrap div located in header.php closing tag-->
<?php
include 'include/footer.php';
?> 