
<?php 
$query_wo= isset($_GET['wo']) ? $_GET['wo'] :  "main" ; 
?>


<header>
    <div class="container flex-center">
        <ul class="language">
            <li><a  href="<?php echo $_SERVER["PHP_SELF"]."?wo=".$query_wo."&lang=english"; ?>">EN</a></li>
            <li><a href="<?php echo $_SERVER["PHP_SELF"]."?wo=".$query_wo."&lang=germany"; ?>">DEU</a></li>
        </ul>
        <ul class="navbar-ul-link flex-center">
            <li><a href="#"><?php echo lang("home");?></a></li>
            <li><a href="#"><?php echo lang("categories");?></a></li>
            <li><a href="#"><?php echo lang("item");?></a></li>
            <li><a href="members.php"><?php echo lang("member");?></a></li>
            <li><a href="#"><?php echo lang("statics");?></a></li>
            <li><a href="#"><?php echo lang("logs");?></a></li>
        </ul>
        <div class="logo"></div>
        <ul class="navbar-user flex-center">
           <li class="user"><a href="#"><?php if(isset($_SESSION["username"])){echo $_SESSION["username"];}else{echo lang("user");}?></a><i class="fas fa-caret-down"></i></li>
           <ul class="dropdown flex-center">
            <li class="flex-center"><a href="members.php?wo=edit<?php if(isset($_SESSION["userid"])){echo "&id=".$_SESSION['userid'];} ?>"><?php echo lang("edit porfile");?></a></li>
            <li class="flex-center"><a href="dashbord.php?wo=settings"><?php echo lang("settings");?></a></li>
            <li class="flex-center"><a href="log_out_page.php"><?php echo lang("log out");?></a></li>  
           </ul>
        </ul>
        <div class="navbar-icon"><i class="fas fa-bars"></i></div>
    </div>
</header>






