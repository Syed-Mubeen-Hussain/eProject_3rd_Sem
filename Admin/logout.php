<?php
include('connection.inc.php');

unset($_SESSION['ADMIN_LOGIN']);
unset($_SESSION['ADMIN_ID']);   
unset($_SESSION['ADMIN_USERNAME']);
unset($_SESSION['ADMIN_ROLE']);
echo "<script>window.location.href = 'login.php'</script>";
?>