<?php
require_once "db_params.php";
 $cnn = db_connect();
 $id = strip_tags($_POST["id"]);
 $Name =strip_tags($_POST['Name']); 
$Adress =strip_tags($_POST['Adress']);
db_execute($cnn, "UPDATE Shippers SET [Name] = '". $Name . "', [Adress] = '". $Adress ."'
     WHERE [id]='".$id."'");
$con=null;
require_once "classShipper.php";
$editShipp = new Shipper();

$editShipp->id = $id;
$editShipp->name = $Name;
$editShipp->adress = $Adress;

echo json_encode($editShipp);

?>	