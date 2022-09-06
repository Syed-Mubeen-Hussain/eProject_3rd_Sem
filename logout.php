<?php
include('connection.inc.php');
unset($_SESSION['USER_LOGIN']);
unset($_SESSION['USER_ID']);
unset($_SESSION['USER_IMAGE']);
unset($_SESSION['USER_NAME'] );
echo "<script>window.location.href = 'login.php'</script>";
?>