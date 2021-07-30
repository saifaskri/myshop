<?php
//routers
$js_path="../layout/js/";
$css_path="../layout/css/";
$tmplate_path="../includes/tamplates/";
$functions_path="../includes/functions/";
$connect_database=$functions_path."databaseFunction.php";
$lang_path="../includes/languages/";
$language_is="english";
//make the choosen Lunaguage in the cokies + security
if(isset($_GET["lang"])){
    switch($_GET["lang"]){
     case "english": $language_is=$_GET["lang"];setcookie("language",$_GET["lang"],time()+3600 );break;
     case "germany": $language_is=$_GET["lang"];setcookie("language",$_GET["lang"],time()+3600 );break;
     //add other lunguage here
     default:if( isset($_COOKIE["language"])){$language_is=$_COOKIE["language"];}break;
    }
}else{if(isset($_COOKIE["language"])){$language_is=$_COOKIE["language"];}else{$language_is="english";}}



// include the first section of page like header and navbar
include $functions_path."myfunction.php";
// include the language file depending on the variabel
which_languages($lang_path);
include $tmplate_path."header.php";
if (isset($NavBarYes)){include $tmplate_path."navbar.php";}
//include connect to data base function in admin page under 2 conditions
if (isset($connect_to_database_Yes)){include $connect_database;}







?>