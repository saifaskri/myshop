<?php 

/*get and set page titel for the page function V 1.0
**Deufault Page
** write  Your prefered Titel of the page on the top of page in this variabel
** =====> $page_titel
*/ 
function getTitel(){global $page_titel;if (isset($page_titel)){echo $page_titel;}else{echo "Page";}}







/*  choose wich language  function V 1.0
**you can add any language path bat path in includes/language
*/ 

function which_languages($lang_path){
global $language_is;
if(isset($language_is)){

    switch($language_is){
        case "english":  include $lang_path."english.php";
        break;
        case "germany":  include $lang_path."germany.php";
        break;
    }

}else{
 include $lang_path."english.php";
}   


}









/*check for for duplicate entry function V 1.0
** $column=>>which column you want to find 
** $conn===>Your PDO object 
** $data==>the data to be checked
** $tabel====>the name of your Table
** you must filter all your input field
** if the entered informations are present then will give True
*/ 

function check_for_duplicate_entry($conn,$tabel,$column,$datas){
$query="SELECT * FROM ".$tabel." WHERE ".$column."=:data; ";

$data=filter_var($datas,FILTER_SANITIZE_EMAIL);

$get=$conn->prepare($query);


$get->bindParam(":data",$data);

$get->execute();

$row=$get->rowCount();
if($row==0){return false;}
else{return true ;}

}






// =================================================================================
// check for for duplicate entry function V 0.0 no upgrade
//just for Testing

 // if there is duplicate give true 
function check_duplicate_email($conn,$emails){
$query="SELECT * FROM `user` WHERE email=:e";
$email=filter_var($emails,FILTER_SANITIZE_EMAIL);
$get=$conn->prepare($query);
$get->bindParam(":e",$email);
$get->execute();
$row=$get->rowCount();
if($row==0){return false;}
else{return true ;}}
// ========
function check_duplicate_username($conn,$users){
    $query="SELECT * FROM `user` WHERE username=:username";
    $username=filter_var($users,FILTER_SANITIZE_SPECIAL_CHARS);
    $get=$conn->prepare($query);
    $get->bindParam(":username",$username);
    $get->execute();
    $row=$get->rowCount();
    if($row==0){return false;}
    else{return true;}}
// =========================================================================
// ====================================================================================



/* get a table form the data base function V1.0
**chosse which column name and which from database
**$conn=> your PDO object
** $table which table
**$column_table_name=> the name oh the headers of table
**$column_table_name_in_database=>same column's name as in dababase
**$add_somthing_to_the_last_table_column =>
if you want to add a only one column to the table 
and write what inside this column(must be in the last of the variale ($column_table_name));
variable sytaxe exemple=>>>:
$column_table_name=array("ID","Email","Usename","registered Date","Actions");
$column_table_name_in_database=array("id","email","username","registered Date",);
$add_somthing_to_the_last_table_column= '<td><button type="button" class="btn btn-warning">Add</button><button type="button" class="btn btn-danger">Deleate</button></td>';
**add classes as you want ^__^
*/


function fetch_database_to_table( $conn,$table,$column_table_name, $column_table_name_in_database,$add_somthing_to_the_last_table_column=""){
    
    // =======================================================================
    $query="SELECT * FROM ".$table ;
    $get=$conn->prepare($query);
    $get->execute();
    $row_num=$get->rowCount();
    $data=$get->fetchALL(PDO::FETCH_ASSOC);
    
    echo'<table border="1">';
    
    for ($i=0;$i<count($column_table_name);$i++){
    echo '<th>'. $column_table_name[$i].'</th>'; }
    
    for ($i=0;$i<$row_num;$i++){
        
    echo'<tr>';
    for ($j=0;$j<count($column_table_name_in_database);$j++){
        echo '<td>'.$data[$i][$column_table_name_in_database[$j]].'</td>';}       
     
        echo  $add_somthing_to_the_last_table_column;


    echo'</tr>';}
    
        
    
    echo '</table>';
}










/*

*/





























?>