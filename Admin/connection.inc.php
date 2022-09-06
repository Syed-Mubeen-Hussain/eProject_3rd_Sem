<?php
session_start();
date_default_timezone_set("Asia/Karachi");
$con = mysqli_connect('localhost','root','','arts');
if(!$con){
    echo "Connection Failed";
}

define("SERVER_PATH",$_SERVER['DOCUMENT_ROOT'].'/eProject/');
define("SITE_PATH",'http://localhost/eProject/');

define("IMAGE_SERVER_PATH",SERVER_PATH.'media/images/');
define("IMAGE_SITE_PATH",SITE_PATH.'media/images/');

?>