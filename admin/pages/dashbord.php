<?php
session_start();
session_regenerate_id();
$NavBarYes='';
$page_titel="dashbord";
$wo="";
include "init.php";





    if( isset($_SESSION["username"]) && isset($_SESSION["userid"]) ){

        echo "welcome in dashbord";










    }else{
        // there is no session must login first
         header("Location:admin.php");
    }







include $tmplate_path."footer.php";

?>