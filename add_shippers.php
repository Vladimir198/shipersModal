<?php 
require_once "db_params.php";
$cnn = db_connect();
$rs;
$id;
$Name = db_check_str_param(strip_tags($_GET['Name'])); 
$Adress =db_check_str_param(strip_tags($_GET['Adress']));

if ($Name !="") {
	db_execute($cnn, "INSERT INTO Shippers ([Name], [Adress]) 
		VALUES ('".$Name."','".$Adress."')" );
	$rs = db_execute($cnn, "SELECT MAX([id]) as 'id' from Shippers where [Name] = '".$Name."'and [Adress] = '".$Adress. "'");
	$id = $rs->Fields['id']->Value;
}
$con = $rs = null;

require_once "classShipper.php";

$shpp = new Shipper();
$shpp->id = $id;
$shpp->name = $Name;
$shpp->adress = $Adress;

echo json_encode($shpp);
?>