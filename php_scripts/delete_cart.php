<?php
//================= DATABASE CONNECT ======================
require_once '../include/config.php';

// ======== IF CUSTOMER IS NOT LOGGED IN REDIRECT TO INDEX ==========
if(!$_SESSION['cust_email']) {
    header("Location:../index.php");
    die;                               //close database connection
}

//======= IF CUSTOMER LOGGED IN DELETE CART ITEM ==========

if(isset($_SESSION['cust_id'])) {
    
    $pid = ($_GET['pid']);
    $cid = ($_SESSION['cust_id']);

    $sql  = "DELETE FROM cart WHERE customerID = :cid AND productID = :pid";
     
    $stmt = $DB->prepare($sql);
    $stmt->bindValue(":cid", $cid); 
    $stmt->bindValue(":pid", $pid);
    $stmt->execute();
    
    header("location:../cart.php");
}

?>