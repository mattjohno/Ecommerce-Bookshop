<?php
//================= DATABASE CONNECT =====================
require '../include/config.php';

//=== IF SESSION (LOGIN) NOT CREATED REDIRECT TO adminLogin.php ===
if(!$_SESSION['admin_email']) {
    header("Location:../adminLogin.php");
    die;                                       //close database connection
}

$mode = $_REQUEST["mode"]; // identify update or add_new
/*================================== ADD NEW PRODUCT ========================================*/ 
if ($mode == "add_new") {
    $product_code  = strip_tags(trim($_POST['product_code']));
    $author        = strip_tags(trim($_POST['author']));
    $title         = strip_tags(trim($_POST['title']));
    $year          = strip_tags(trim($_POST['year']));
    $publisher     = strip_tags(trim($_POST['publisher']));
    $price         = strip_tags(trim($_POST['price']));
    $description   = strip_tags(trim($_POST['description']));
    $filename      = "";
    $error       = FALSE;
    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
        $filename = time() . '_' . $_FILES["image"]["name"];
        $filepath = '../product_pics/' . $filename;
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $filepath)) {
            $error = TRUE;
        }
    }
/*================================== CHECK FOR EXISTING PRODUCTS ========================================*/    
    if (!$error) {
        $sql  = "SELECT productCode, author, title, year FROM products WHERE productCode = :product_code AND author = :author AND title = :title AND year = :year";
            try {
                $stmt = $DB->prepare($sql);
                // bind the values
                $stmt->bindValue(":product_code", $product_code);
                $stmt->bindValue(":author", $author);
                $stmt->bindValue(":title", $title);
                $stmt->bindValue(":year", $year);
                // execute Query
                $stmt->execute();

                $result = $stmt->rowCount();
                if ($result > 0) {
                    $_SESSION["errorType"] = "info";
                    $_SESSION["errorMsg"]  = "Product already exists.";
/*================================== INSERT NEW PRODUCTS ==========================================*/         
                } else if ($result === 0) {
        $sql = "INSERT INTO products (productCode, author, title, year, publisher, price, productDesc, imagePath) 
        VALUES " . "(:product_code, :author, :title, :year, :publisher, :price, :description, :filename)";
            try {
                $stmt = $DB->prepare($sql);
                // bind the values
                $stmt->bindValue(":product_code", $product_code);
                $stmt->bindValue(":author", $author);
                $stmt->bindValue(":title", $title);
                $stmt->bindValue(":year", $year);
                $stmt->bindValue(":publisher", $publisher);
                $stmt->bindValue(":price", $price);
                $stmt->bindValue(":filename", $filename);
                $stmt->bindValue(":description", $description);
                // execute Query
                $stmt->execute();
/*================================== RETURN RESULT MESSAGE ==========================================*/   
                $result = $stmt->rowCount();
                if ($result > 0) {
                    $_SESSION["errorType"] = "success";
                    $_SESSION["errorMsg"]  = "Product added successfully.";
                } else {
                    $_SESSION["errorType"] = "info";
                    $_SESSION["errorMsg"]  = "Failed to add product.";
                }
           }
            catch (Exception $ex) {
                $_SESSION["errorType"] = "warning";
                $_SESSION["errorMsg"]  = $ex->getMessage();
                }
            }
        }
        catch (Exception $ex) {
            $_SESSION["errorType"] = "warning";
            $_SESSION["errorMsg"]  = $ex->getMessage();
            }
        } else {
            $_SESSION["errorType"] = "info";
            $_SESSION["errorMsg"]  = "failed to upload image.";
        }
    header("location:../adminCatalogue.php");
/*================================ UPDATE EXISTING PRODUCT ==================================*/
} else if  ($mode == "update_old") { 
    $product_code  = strip_tags(trim($_POST['product_code']));
    $author        = strip_tags(trim($_POST['author']));
    $title         = strip_tags(trim($_POST['title']));
    $year          = strip_tags(trim($_POST['year']));
    $publisher     = strip_tags(trim($_POST['publisher']));
    $price         = strip_tags(trim($_POST['price']));
    $description   = strip_tags(trim($_POST['description']));
    $cid           = strip_tags(trim($_POST['cid']));
    $filename      = "";
    $error       = FALSE;
    if (is_uploaded_file($_FILES["image"]["tmp_name"])) {
        $filename = time() . '_' . $_FILES["image"]["name"];
        $filepath = '../product_pics/' . $filename;
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $filepath)) {
            $error = TRUE;
     }
    } else {
        $filename = $_POST['old_pic'];
    }
    if (!$error) {
        $sql = "UPDATE products SET productCode = :product_code, author = :author, title = :title, year = :year, publisher = :publisher, price = :price, productDesc = :description, imagePath = :filename " . "WHERE productID = :cid ";
        try {
            $stmt = $DB->prepare($sql);
            // bind the values
            $stmt->bindValue(":product_code", $product_code);
            $stmt->bindValue(":author", $author);
            $stmt->bindValue(":title", $title);
            $stmt->bindValue(":year", $year);
            $stmt->bindValue(":publisher", $publisher);
            $stmt->bindValue(":price", $price);
            $stmt->bindValue(":filename", $filename);
            $stmt->bindValue(":description", $description);
            $stmt->bindValue(":cid", $cid);
            // execute Query
            $stmt->execute();
            $result = $stmt->rowCount();
            if ($result > 0) {
                $_SESSION["errorType"] = "success";
                $_SESSION["errorMsg"]  = "Product updated successfully.";
            } else {
                $_SESSION["errorType"] = "info";
                $_SESSION["errorMsg"]  = "No changes made to contact.";
            }
        }
        catch (Exception $ex) {
            $_SESSION["errorType"] = "info";
            $_SESSION["errorMsg"]  = $ex->getMessage();
        }
    } else {
        $_SESSION["errorType"] = "info";
        $_SESSION["errorMsg"]  = "Failed to upload image.";
    }
    header("location:../adminCatalogue.php?pagenum=" . $_POST['pagenum']);
}

/*================================== DELETE PRODUCT ========================================*/ 
else if ($mode == "delete") {
    $cid = intval($_GET['cid']);
    $sql = "DELETE FROM products WHERE productID = :cid";
    try {
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":cid", $cid);
        $stmt->execute();

/*============================== RETURN RESULT MESSAGE =====================================*/                
        $res = $stmt->rowCount();
        if ($res > 0) {
            $_SESSION["errorType"] = "success";
            $_SESSION["errorMsg"]  = "Product deleted successfully.";
        } else {
            $_SESSION["errorType"] = "info";
            $_SESSION["errorMsg"]  = "Failed to delete product.";
        }
    }
    catch (Exception $ex) {
        $_SESSION["errorType"] = "info";
        $_SESSION["errorMsg"]  = $ex->getMessage();
    }
    header("location:../adminCatalogue.php?pagenum=" . $_GET['pagenum']);
}
?>