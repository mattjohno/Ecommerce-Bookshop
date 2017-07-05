<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="TAFE assessment">
    <meta name="keywords" content="HTML,PHP, SQL, Bootstrap, JavaScript, JQuery Alphanum">
    <meta name="author" content="Matthew Johnson">

    <title>Tech Reader</title>

    <!-- Bootstrap -->
    <link href="bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="style/style.css" rel="stylesheet">

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>-->
    <script src="bootstrap/js/html5shiv.js"></script>
    <script src="bootstrap/js/respond.min.js"></script>
    <!--[endif]-->
    <script src="bootstrap/js/jquery-1.9.0.min.js"></script>
    <script src="bootstrap/js/jquery.alphanum.js"></script>
  </head>
  
  <body>
   <div class="page-wrap">
    <!-- navbar -->
        <nav class="navbar navbar-default navbar-fixed-top" role="navigation">
        <div class="container">
            <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                
                <a class="navbar-brand" href="index.php">
                    Tech Reader
                </a>
            </div>
            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse navbar-right" id="bs-example-navbar-collapse-1">
                <ul class="nav navbar-nav">
                    <li>
                        <a href="index.php">Home</a>
                    </li>
                    <li>
                        <a href="about.php">About</a>
                    </li>
                    <li>
                        <a href="prodCatalogue.php">Products</a>
                    </li>
                    <li>
                        <a href="contact.php">Contact</a>
                    </li>
                    
                    <?php
                    if(isset($_SESSION['admin_email'])) {
                        echo '<li><a href="adminCatalogue.php">Update Catalogue</a></li>';
                        echo  '<div class="nav navbar-left navbar-btn hidden-sm hidden-md hidden-lg">
                                <a href="getProdDet.php" class="btn btn-success rounded pull-left">
                                <i class="glyphicon glyphicon-plus"></i> 
                                Add New Product
                                </a>
                                </div>';
                    } else if (!$_SESSION['cust_email']) { 
                        echo '<li><a href="getCustDet.php">Register</a></li>';
                        echo '<li><a href="customerLogin.php">Login</a></li>';
                    } else {
                        echo '<li class="dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" 
                            aria-haspopup="true" aria-expanded="false">My Account <span class="caret"></span></a>
                                <ul class="dropdown-menu">
                                    <li><a href="account_details.php">Account Details</a></li>
                                    <li><a href="cart.php">View Cart</a></li>
                                    <li><a href="orders.php">View Orders</a></li>
                              </ul>
                            </li>';
                        echo '<li><a href="php_scripts/logout.php">Logout</a></li>';
                    }
                    ?>        
                </ul>
            </div>
            <!-- /.navbar-collapse -->
        </div>
        <!-- /.container -->
       </nav>