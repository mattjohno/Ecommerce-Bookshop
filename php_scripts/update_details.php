<?php
//================= DATABASE CONNECT =====================
require_once '../include/config.php';

// ======== IF CUSTOMER IS NOT LOGGED IN REDIRECT TO INDEX ==========
if(!$_SESSION['cust_email']) {
    header("Location:../index.php");
    die;                               //close database connection
}

if(isset($_SESSION['cust_id'])) {

$first_name  = strip_tags(trim($_POST['first_name']));
$last_name   = strip_tags(trim($_POST['last_name']));
$address     = strip_tags(trim($_POST['address']));
$city        = strip_tags(trim($_POST['city']));
$postcode    = strip_tags(trim($_POST['postcode']));
$phone       = strip_tags(trim($_POST['phone']));
$vip_num      = strip_tags(trim($_POST['vip_num']));
$cid         = $_SESSION['cust_id'];

/*================================== UPDATE CUSTOMER DETAILS ========================================*/ 

$sql  = "UPDATE customers SET firstName = :first_name, lastName = :last_name, address = :address, city = :city, postcode = :postcode, phone = :phone, vipNum = :vip_num WHERE customerID = :cid";
try {
    $stmt = $DB->prepare($sql);
    $stmt->bindValue(":first_name", $first_name);
    $stmt->bindValue(":last_name", $last_name);
    $stmt->bindValue(":address", $address);
    $stmt->bindValue(":city", $city);
    $stmt->bindValue(":postcode", $postcode);
    $stmt->bindValue(":phone", $phone);
    $stmt->bindValue(":vip_num", $vip_num);
    $stmt->bindValue(":cid", $cid);
    // execute Query
    $stmt->execute();
        $result = $stmt->rowCount();
        if ($result > 0) {
            $_SESSION["errorType"] = "success";
            $_SESSION["errorMsg"]  = "Contact updated successfully.";
        } else {
            $_SESSION["errorType"] = "info";
            $_SESSION["errorMsg"]  = "No changes made to contact.";
        }
    }
    catch (Exception $ex) {
        $_SESSION["errorType"] = "failure";
        $_SESSION["errorMsg"]  = $ex->getMessage();
    }
}

header("location:../prodCatalogue.php");

?>