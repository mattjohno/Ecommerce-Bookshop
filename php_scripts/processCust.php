<?php
//================= DATABASE CONNECT =====================
require_once '../include/config.php';




/*================================== REGISTER CUSTOMER========================================*/ 
$first_name  = strip_tags(trim($_POST['first_name']));
$last_name   = strip_tags(trim($_POST['last_name']));
$address     = strip_tags(trim($_POST['address']));
$city        = strip_tags(trim($_POST['city']));
$postcode    = strip_tags(trim($_POST['postcode']));
$phone       = strip_tags(trim($_POST['phone']));
$vip_no      = strip_tags(trim($_POST['vip_num']));
$email       = strip_tags(trim($_POST['email_id']));
$password    = strip_tags(trim($_POST['password']));
$password    = md5(md5($email.$password));

/*================================== CHECK FOR EXISTING PRODUCTS ========================================*/ 
if (!$error) {
    $sql  = "SELECT email FROM customers WHERE email = :email";
        try {
        $stmt = $DB->prepare($sql);
        // bind the values
        $stmt->bindValue(":email", $email);
        // execute Query
        $stmt->execute();

        $result = $stmt->rowCount();
        if ($result > 0) {
            header("location:../getCustDet.php");
            $_SESSION["errorType"] = "info";
            $_SESSION["errorMsg"]  = "Email address already exists";
/*================================== INSERT NEW CUSTOMER ========================================*/ 
        } else if ($result === 0) {
            $sql = "INSERT INTO customers (firstName, lastName, address, city, postcode, phone, vipNum, email, password) 
            VALUES " . "( :first_name, :last_name, :address, :city, :postcode, :phone, :vip, :email, :password)";
            try {
                $stmt = $DB->prepare($sql);
                // bind the values
                $stmt->bindValue(":first_name", $first_name);
                $stmt->bindValue(":last_name", $last_name);
                $stmt->bindValue(":address", $address);
                $stmt->bindValue(":city", $city);
                $stmt->bindValue(":postcode", $postcode);
                $stmt->bindValue(":phone", $phone);
                $stmt->bindValue(":vip", $vip_no);
                $stmt->bindValue(":email", $email);
                $stmt->bindValue(":password", $password);
                // execute Query
                $stmt->execute();
/*================================== RETURN RESULT MESSAGE ==========================================*/
                $result = $stmt->rowCount();
                if ($result > 0) {
                    header("location:../customerLogin.php");
                    $_SESSION["errorType"] = "success";
                    $_SESSION["errorMsg"]  = "Registration successful, please log in.";
                } else {
                    header("location:../getCustDet.php");
                    $_SESSION["errorType"] = "info";
                    $_SESSION["errorMsg"]  = "Failed to add contact.";
                }
            }
            catch (Exception $ex) {
                header("location:../getCustDet.php");
                $_SESSION["errorType"] = "failure";
                $_SESSION["errorMsg"]  = $ex->getMessage();
            }
        }
    }
    catch (Exception $ex) {
    header("location:../getCustDet.php");   
    $_SESSION["errorType"] = "warning";
    $_SESSION["errorMsg"]  = $ex->getMessage();
    }
}

?>