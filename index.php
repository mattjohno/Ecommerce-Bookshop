<?php
//===================== Database connect and header =====================
require_once 'include/config.php';
include 'include/header.php';
?>

<!--====================== Background image ==========================-->
<div id="hero">
    <div id="hero-overlay">Tech Books Online</div>
</div>

</div><!--page-wrap div located in header.php closing tag-->

<!--================== Footer =========================-->
<?php
include 'include/footer.php';
?>

<!--========= Image = screen height minus footer =========-->
<script>
    $("#hero").css("height",$(window).height() - 110);
</script>