<?php
//================= DATABASE CONNECT =====================
require_once '../include/config.php';

//====================== IF ADMIN LOGIN FORM SUBMITTED ============================
if(isset($_POST['admin_login'])) {
    
    $email = ($_POST['admin_email']);
    $password = ($_POST['admin_password']);
    
    $sql = "SELECT * FROM admin WHERE email = :email AND password = :password";
    
    try {
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":password", $password);
        $stmt->execute();
        
        $result = $stmt->rowCount();
        
        if ($result > 0) {
            $_SESSION['admin_email'] = $email;
            $_SESSION["errorType"] = "success";
            $_SESSION['errorMsg'] = "Admin successfully logged in";
            header('location:../adminCatalogue.php');    
        } else {
            $_SESSION["errorType"] = "info";
            $_SESSION['errorMsg'] = "Invalid Login, Try Again";
            header('location:../adminLogin.php');
        }
    } catch (Exception $ex) {
        $_SESSION["errorType"] = "failure";
        $_SESSION["errorMsg"] = $ex->getMessage();
        header('location:../adminLogin.php');
    }
}

//====================== IF CUSTOMER LOGIN FORM SUBMITTED ============================
if(isset($_POST['cust_login'])) {
    
    $email       = ($_POST['cust_email']);
    $password    = ($_POST['cust_pass']);
    $password    = md5(md5($email.$password));
    
    $sql = "SELECT * FROM customers WHERE email = :email AND password = :password";
    
    try {
        $stmt = $DB->prepare($sql);
        $stmt->bindValue(":email", $email);
        $stmt->bindValue(":password", $password);
        $stmt->execute();
        
        $result = $stmt->rowCount();                    //check number of effected rows
        $row = $stmt->fetch();                          //fetch row
                
        if ($result > 0) {
            $_SESSION['cust_email'] = $email;           //curomer email value
            $_SESSION['cust_id'] = $row['customerID'];  //customer ID value
            $_SESSION["errorType"] = "success";
            $_SESSION['errorMsg'] = $_SESSION['cust_email'] . " successfully logged in";
            header('location:../prodCatalogue.php');    
        } else {
            $_SESSION["errorType"] = "info";
            $_SESSION['errorMsg'] = "Invalid Login. Register or try again.";
            header('location:../customerLogin.php');
        }
    } catch (Exception $ex) {
        $_SESSION["errorType"] = "failure";
        $_SESSION["errorMsg"] = $ex->getMessage();
        header('location:../customerLogin.php');
    }
}

?>