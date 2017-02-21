<?php 
include "db_params.php";
$cnn = db_connect();
$Name =strip_tags($_POST['Name']); 
$Adress =strip_tags($_POST['Adress']);

if ($Name !="") {
	db_execute($cnn, "INSERT INTO Shippers ([Name], [Adress]) 
		VALUES ('".$Name."','".$Adress."')" );
}
$con = null;
?>