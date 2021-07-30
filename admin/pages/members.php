<?php
//here we can [edit, ]
session_start();
session_regenerate_id();
$connect_to_database_Yes="";
$NavBarYes="";
$page_titel="alles";
$wo="";
include "init.php"; 

if(isset($_SESSION["username"])&&isset($_SESSION["userid"])){

                    if(isset($_GET["wo"])&&(! empty($_GET["wo"]))){  
                    $wo=$_GET["wo"];
                    }else{
                    $wo="main";   
                    }

        if($wo=="main"){
           //main page
            echo "<h1>welcom in main page </h1> ";
            
$column_table_name=array("ID","Email","Usename","registered Date","Actions");
$column_table_name_in_database=array("id","email","username","registered Date",);
$a= '<td><button type="button" class="btn btn-warning">Add</button><button type="button" class="btn btn-danger">Deleate</button></td>';

 fetch_database_to_table( $conn,"user",$column_table_name,$column_table_name_in_database,$a);


?> 
<a href="members.php?wo=Add"> enzel lahna bech tzid chkoun</a>





<?php



        }
        // $email=     filter_var($_POST["email"],FILTER_SANITIZE_EMAIL);
        // $password=  sha1(htmlspecialchars($_POST["password"]));
        // $username= filter_var($_POST["username"],FILTER_SANITIZE_STRING); 
// =============================================================================================================

        elseif($wo=="edit"){
//edit page
               
if(isset($_SESSION['wrong_password_trys'])&&$_SESSION['wrong_password_trys']>2){
    $_SESSION["many_bad_password"]=true;
     if(isset($_SESSION["many_bad_password"])&&($_SESSION["password_wrong"])){ echo
        "<div class='msg-edit'>
            <p>Your Wrote a false Password Many Time successively </p>
        </div>";$_SESSION["many_bad_password"]=false;}
        header( "Refresh:3; url=log_out_page.php");
}else{

    if(isset($_GET["id"])&&is_numeric($_GET["id"])){
        $userid= intval ($_GET["id"]);
        }else{$userid=-103;}

if($userid==-103){
header("Location:log_out_page.php");
}else{
$query="SELECT * FROM `user` WHERE id=:id";
$get=$conn->prepare($query);
$get->bindParam(":id",$userid);
$get->execute();
$row=$get->rowCount();

        if( $row>0){
            $data=$get->fetch(PDO::FETCH_ASSOC );
            ?>
            <h1 class="edit-page-titel">Edit Page</h1>
            <div class="container">
                <form class="edit-form" action="members.php?wo=update" method="post">
                    <!-- <div class="label-input">
                        <label for="">Email</label>
                        <input type="email" name="email" value="<?php echo $data["email"] ; ?>" autocomplete="off" >
                    </div> -->
                    <div class="label-input">
                    <label for="">UserName</label>
                    <input type="text" name="username" value="<?php echo $data["username"] ; ?>"autocomplete="off" >
                    </div>
                    <div class="label-input">
                    <label for="">Password</label>
                    <input type="password" name="password" autocomplete="new-password" >
                    </div>
                    <input type="hidden" name="id" value="<?php echo $userid; ?>">
                    <input class="but-edit" type="submit" name="updaten" value="Update">
                </form>
                <?php if(isset($_SESSION["password_wrong"])&&($_SESSION["password_wrong"])){ echo
                "<div class='msg-edit'>
                    <p>Your Password is invalid</p>
                </div>";$_SESSION["password_wrong"]=false;}?>
                 <?php if(isset($_SESSION["email_exist"])&&($_SESSION["email_exist"])){ echo
                "<div class='msg-edit'>
                    <p>The inputed UserName is used </p>
                </div>"; $_SESSION["email_exist"]=false;}?>
            </div>

            <?php
            }else{

            header("Location:log_out_page.php"); 
            }





}
}


?>




<?php


}




// =============================================================================================================

elseif($wo=="update"){
 //update page

 if(isset($_POST["updaten"])&&isset($_POST["password"])){
    $query="SELECT * FROM `user` WHERE password=:pass";
    $password=  sha1(htmlspecialchars($_POST["password"]));
    $get=$conn->prepare($query);
    $get->bindParam(":pass",$password);
    $get->execute();
    $row=$get->rowCount();

                                //password is valid
                                if( $row>0){

                                    
                                    $query="SELECT * FROM `user` WHERE username=:username AND id!=:id ";
                                    $id=$_POST["id"];
                                    // $email=filter_var($_POST["email"],FILTER_SANITIZE_EMAIL);
                                    $username= filter_var($_POST["username"],FILTER_SANITIZE_STRING); 
                                    $get=$conn->prepare($query);
                                    $get->bindParam(":username",$username);
                                    $get->bindParam(":id",$id);
                                    $get->execute();
                                    $row=$get->rowCount();
                                    //if the inputed username was not been used
                                    if($row==0){
                                                $_SESSION["password_wrong"]=false;
                                                // $email=     filter_var($_POST["email"],FILTER_SANITIZE_EMAIL);
                                                $password=  sha1(htmlspecialchars($_POST["password"]));
                                                $username= filter_var($_POST["username"],FILTER_SANITIZE_STRING); 
                                                $query="UPDATE `user` SET   username=:username WHERE  password=:pass";
                                                $password=  sha1(htmlspecialchars($_POST["password"]));
                                                $get=$conn->prepare($query);
                                                $get->bindParam(":pass",$password);
                                                // $get->bindParam(":email",$email);
                                                $get->bindParam(":username",$username);
                                                
                                                if($get->execute()){
                                                    
                                                        echo "<div class='msg-edit'>
                                                            <p>All Modification Has Been Changed</p>
                                                        </div>";

                                                }else{echo "<div class='msg-edit'>
                                                            <p>Somthing Went Wrong</p>
                                                            </div>";
                                                }

                                            }else{
                                                $_SESSION["email_exist"]=true;
                                                header("Location:members.php?wo=edit&id=".$_POST["id"]);
                                            }  
                                }else{
                                    if(isset( $_SESSION['wrong_password_trys'])){
                                    $_SESSION['wrong_password_trys']++;}
                                    $_SESSION["password_wrong"]=true;
                                    header("Location:members.php?wo=edit&id=".$_POST["id"]);
                                
                                }
                                    
  
                                    

 }

           
    
 





}


// =============================================================================================================

elseif($wo=="Add"){
//ADD page  
?>

 <h2 class="edit-page-titel">Add Members Page</h1>
    <form class="edit-form" action="members.php?wo=Add" method="post">
    <div class="label-input">
        <label for="">Email</label>
        <input type="email" name="email" placeholder="<?php echo lang("email_placeholder") ?>" autocomplete="off" >
    </div>
    <div class="label-input">
    <label for="">UserName</label>
    <input type="text" name="username" placeholder="<?php echo lang("username_placeholder") ;?>"autocomplete="off" >
    </div>
    <div class="label-input">
    <label for="">Password</label>
    <input type="password" name="password" autocomplete="new-password" >
    </div>
    <div class="label-input">
    <label for="">Verify Password</label>
    <input type="password" name="verify_password" autocomplete="new-password" >
    </div>
    <input class="but-edit" type="submit" name="adduser" value="<?php echo lang("Add") ?>">
</form>
<?php
    


if(isset($_POST["adduser"])){
$email=filter_var($_POST["email"],FILTER_SANITIZE_EMAIL);
$username=filter_var($_POST["username"],FILTER_SANITIZE_SPECIAL_CHARS);
$password= sha1(htmlspecialchars($_POST["password"]));
$error_add_account=array();
$error_add_account_duplicate=array();

// ====================start check=====================
// //check if email and username are not empty
//if(empty($_POST["username"])){$error_add_account[]="UserName can't be empty"."<br>";}
//if(empty($_POST["email"])){$error_add_account[]="Email can't be empty"."<br>";}
//check if email is between 5 and 50 caracters   
if(!((strlen($_POST["email"])<50)&&strlen($_POST["email"])>5)){$error_add_account[]="Email Length Must Be Between 5 and 50 caracters"."<br>";}
//check if username is between 4 and 20 caracters   
if(!((strlen($_POST["username"])<20)&&strlen($_POST["username"])>4)){$error_add_account[]="Username Length Must Be Between 4 and 20 caracters"."<br>";}
//check if password match 
if(!($_POST["password"]===$_POST["verify_password"])){$error_add_account[]="Password Don't Match"."<br>";}
//check if password more than 8 caracters 
if(strlen($_POST["password"])<7){$error_add_account[]="Password Must be more than 8 caracteres"."<br>";}
// //check if password not empty
// if(strlen($_POST["password"])==0){$error_add_account[]="Password Can't Be Empty"."<br>";}
// ====================end check=====================

//if there is  error 
if(!empty($error_add_account)){

        foreach ($error_add_account as $value) {
        echo $value."<br>";
        }
}

//start test for  deplucate entry block
if(check_for_duplicate_entry($conn,"user","username",$email)){$error_add_account_duplicate[]="This Email ".$email." is Used <br>";}
if (check_for_duplicate_entry($conn,"user","username",$username)){$error_add_account_duplicate[]="This Username ".$username." is Used <br>";} 
//end test for  deplucate entry block




//start if finally there is no error
if(empty($error_add_account_duplicate)&&(empty($error_add_account))){
//"no error  ^__^
$query='INSERT INTO user ( email, password, username) VALUES (:e,:p,:username)';
$get=$conn->prepare($query);
$get->bindParam(":e",$email);
$get->bindParam(":p",$password);
$get->bindParam(":username",$username);
if($get->execute()){echo "done";}else{echo "there is a problem";}
}

// if there is error
else{
foreach ($error_add_account_duplicate as $value) {
echo $value."<br>";
}   
}
//end if finally there is no error





               

        


}




}


// =============================================================================================================


        elseif($wo=="settings"){
            //settings page
            echo "welcom in settings page ";
        }





        else{

            echo "no page with this name ";
        }




        include $tmplate_path."footer.php";




}else{
    // there is no session must login first
     header("Location:admin.php");
}










?>