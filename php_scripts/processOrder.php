<?php
//================= DATABASE CONNECT =====================
require_once '../include/config.php';

// ======== IF CUSTOMER IS NOT LOGGED IN REDIRECT TO LOG IN ==========
if(!$_SESSION['cust_email']) {
    header("Location:../customerLogin.php");
    die;                                        //close database connection
}

/*================================== PROCESS ORDER========================================*/ 
if(isset($_SESSION['cust_id'])) {

$cid  = ($_SESSION['cust_id']);

$sql = "INSERT INTO orders (customerID, productCode, title, author, year, quantity, price)
        SELECT c.customerID, p.productCode, p.title, p.author, p.year, c.quantity, p.price 
        FROM cart AS c INNER JOIN products AS p
        ON c.productID = p.productID WHERE c.customerID = :cid";
    
            try {
                $stmt = $DB->prepare($sql);
                $stmt->bindValue(":cid", $cid);
                $stmt->execute();

                $result = $stmt->rowCount();
                if ($result > 0) { 
                    $_SESSION["errorType"] = "success";
                    $_SESSION["errorMsg"]  = "Your order has been processed.";
                    header("location:../cart.php");
                    
                } else {
                    $_SESSION["errorType"] = "info";
                    $_SESSION["errorMsg"]  = "Failed to process order.";
                    header("location:../cart.php");
                }
            }
            catch (Exception $ex) {
                $_SESSION["errorMsg"] = "warning";
                $_SESSION["errorMsg"]  = $ex->getMessage();
                header("location:../cart.php");
            }

/*============================== REMOVE ITEMS FROM CART=================================*/     
            $sql  = "DELETE FROM cart WHERE customerID = :cid";
     
            $stmt = $DB->prepare($sql);
            $stmt->bindValue(":cid", $cid); 
            $stmt->execute();
}

    