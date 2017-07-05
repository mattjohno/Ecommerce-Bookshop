<?php
   require 'include/config.php';
?>
   
    </div>

    <footer>
      <div class="navbar navbar-default footer">
        <div class="container-fluid">
          <div class="copyright">
              <span>&copy; <?php echo date("Y"); ?> All rights reserved</span>
          </div>
          <div class="copyright">
            <?php
            if(!$_SESSION['admin_email']) { ?>     <!-- if admin is not signed -->
                <a href="adminLogin.php">Admin</a> <!-- Display Admin -->
           <?php 
            } else {                               
            ?>                                     <!-- if admin is signed in -->
            <a href=php_scripts/logout.php>Admin logout</a>    <!-- Display Admin Logout -->
            <?php 
            } 
            ?>
         </div>
        </div>
      </div>
    </footer>

    
    <!-- Include all compiled plugins (below), or include individual files as needed -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
  </body>
</html>