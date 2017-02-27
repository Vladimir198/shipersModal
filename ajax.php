 <?php 
 header('Content-type: text/html; charset=utf-8');
 require_once "db_params.php";
 $cnn = db_connect();
 $rs = db_execute($cnn, "select * from Shippers");
/**
* 
*/
require_once "classShipper.php";
$array  = array();
$i= 0;
while (!$rs->EOF) {
	$shipper = new Shipper();
	$shipper->id = $rs->Fields["id"]->Value;
	$shipper->name = $rs->Fields["Name"]->Value;
	$shipper->adress = $rs->Fields["Adress"]->Value;
	$array[$i] = $shipper;
	$i++;
	$rs->MoveNext();
} 
$con = $rs=null;
echo json_encode($array);
?>
