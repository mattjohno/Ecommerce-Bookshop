<?php
//================= DATABASE CONNECT =====================
require_once '../include/config.php';

//================= IF CUSTOMER NOT LOGGED IN =====================
if(!$_SESSION['cust_email']) {
    $_SESSION["errorType"] = "info";
    $_SESSION["errorMsg"]  = "Please log in first or register.";
    header("Location:../customerLogin.php");
    die;
}

if(isset($_SESSION['cust_id'])) {

$pid       = ($_GET['pid']);
$cid       = ($_SESSION['cust_id']);

/*================================== CHECK FOR EXISTING PRODUCTS ========================================*/ 

$sql  = "SELECT * FROM cart WHERE customerID = :cid AND productID = :pid";
try {
    $stmt = $DB->prepare($sql);
    $stmt->bindValue(":cid", $cid);    
    $stmt->bindValue(":pid", $pid);
    $stmt->execute();
        $result = $stmt->rowCount();
        if ($result > 0) {
            $_SESSION["errorType"] = "info";
            $_SESSION["errorMsg"]  = "This item has already been added to your cart";
            header("location:../prodCatalogue.php");
/*================================== ADD PRODUCT TO CART ========================================*/             
        } else if ($result === 0) {            
             $sql = "INSERT INTO cart (customerID, productID) VALUES (:cid, :pid)";
        try {
            $stmt = $DB->prepare($sql);
            // bind the values
            $stmt->bindValue(":cid", $cid);
            $stmt->bindValue(":pid", $pid);
            // execute Query
            $stmt->execute();

            $result = $stmt->rowCount();
            if ($result > 0) { 
                $_SESSION["errorType"] = "success";
                $_SESSION["errorMsg"]  = "Item successfully added to cart.";
                header("location:../cart.php");

            } else {
                $_SESSION["errorType"] = "info";
                $_SESSION["errorMsg"]  = "Failed to add product to cart.";
                header("location:../prodCatalogue.php");
            }
        }
        catch (Exception $ex) {
            $_SESSION["errorMsg"] = "warning";
            $_SESSION["errorMsg"]  = $ex->getMessage();
            header("location:../prodCatalogue.php");
        }   
        }
    }
    catch (Exception $ex) {
        $_SESSION["errorType"] = "failure";
        $_SESSION["errorMsg"]  = $ex->getMessage();
    }
}

?>

