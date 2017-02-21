<?php
include "db_params.php";
 $cnn = db_connect();
 $Name =strip_tags($_POST['Name']); 
$Adress =strip_tags($_POST['Adress']);
db_execute($cnn, "UPDATE Shippers SET [Name] = '". $Name . "', [Adress] = '". $Adress ."'
     WHERE [id]='".$_POST["id"]."'");
$con=null;
?>	