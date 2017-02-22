<?php 
include "db_params.php";
$cnn = db_connect();
$rs;
$id;
$Name =strip_tags($_GET['Name']); 
$Adress =strip_tags($_GET['Adress']);

if ($Name !="") {
	db_execute($cnn, "INSERT INTO Shippers ([Name], [Adress]) 
		VALUES ('".$Name."','".$Adress."')" );
	$rs = db_execute($cnn, "SELECT MAX([id]) as 'id' from Shippers")
	$id = $rs->Fields['id']->Value;
}
$con = $rs = null;

include "ajax.php";
$arrayShipp = array();
$shpp = new Shipper();
$shpp->id = $id;
$shpp->name = $Name;
$shpp->adress = $Adress;
$arrayShipp[0] = $shpp;
echo json_encode($arrayShipp);
?>