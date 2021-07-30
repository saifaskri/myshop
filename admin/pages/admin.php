
<?php 
session_start();
session_regenerate_id();
$connect_to_database_Yes="";
$NavBarNo="";
$page_titel="Admin log_in";
include "init.php"; 

if(!isset($_SESSION['username'])){

   if($_SERVER['REQUEST_METHOD']=="POST"&&isset($_POST["username"])&&isset($_POST["password"])){
    //filtration of the inputs field + hashing password  
   $username =filter_var($_POST["username"],FILTER_SANITIZE_STRING);
   $password= sha1(htmlspecialchars($_POST["password"]));
   // fetch spezifische Spalten
   $query="SELECT id , username,groupID FROM `user` WHERE username=:e AND password=:p";
   $get=$conn->prepare($query);
   $get->bindParam(":e",$username);
   $get->bindParam(":p",$password);
   $get->execute();
   $row=$get->rowCount();

      if( $row>0){
         session_start();
         $data=$get->fetch(PDO::FETCH_ASSOC );
         $_SESSION["username"]=$data["username"];
         $_SESSION["userid"]=$data["id"];
         $_SESSION['wrong_password_trys']=0;
         header("Location:dashbord.php");
         exit;
      }else{
         echo "invalid inputed data";
      }


}



?>

 <form method="post"  class="form-login" action="admin.php">
    <input type="text" name="username" id="" placeholder="<?php echo lang("username_placeholder");?>" required autocomplete="off">  
    <input type="password" name="password" id="" placeholder="<?php echo lang("password_placeholder");?>" required autocomplete="new-password">  
    <button type="submit"><?php echo lang("sign in");?></button>
 </form>
 

 <?php include $tmplate_path."footer.php";
 }else{
   header("Location:dashbord.php?wo=main");
 }
 ?>



