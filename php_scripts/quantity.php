<?php
//================= DATABASE CONNECT =====================
include '../include/config.php';

// ======== IF CUSTOMER IS NOT LOGGED IN REDIRECT TO INDEX ==========
if(!$_SESSION['cust_email']) {
    header("Location:../index.php");
    die;                            //close database connection
}

if(isset($_SESSION['cust_id'])) {

 $quantity      = $_GET['quantity'];
 $cartID        = $_GET['cartID'];    

//================= CHECK IF QUANTITY HAS BEEN CHANGED =====================
$sql = "SELECT * FROM cart WHERE quantity = :quantity AND cartID = :cartID";
    try {
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":quantity", $quantity);
        $stmt->bindValue(":cartID", $cartID);
        // execute Query
        $stmt->execute();
            $result = $stmt->rowCount();
            if ($result > 0) {
                $_SESSION["errorType"] = "info";
                $_SESSION["errorMsg"]  = "No changes to quantity.";
                 header("location:../cart.php");
                
//================= UPDATE QUANTITY IN CART =====================                
            } else if ($result === 0) {
                $sql = "UPDATE cart SET quantity = :quantity WHERE cartID = :cartID";
            try {
                $stmt = $DB->prepare($sql);
                $stmt->bindValue(":quantity", $quantity);
                $stmt->bindValue(":cartID", $cartID);
                // execute Query
                $stmt->execute();
                
                $result = $stmt->rowCount();
                if ($result > 0) {
                    $_SESSION["errorType"] = "success";
                    $_SESSION["errorMsg"]  = "Quantity updated successfully.";
                    header("location:../cart.php");
                } else {
                    $_SESSION["errorType"] = "info";
                    $_SESSION["errorMsg"]  = "No changes to quantity.";
                    header("location:../cart.php");
                }
            }
            catch (Exception $ex) {
                $_SESSION["errorType"] = "failure";
                $_SESSION["errorMsg"]  = $ex->getMessage();
                header("location:../cart.php");
            }
        }
    }
    catch (Exception $ex) {
        $_SESSION["errorType"] = "failure";
        $_SESSION["errorMsg"]  = $ex->getMessage();
        header("location:../cart.php");
    }
}

?>