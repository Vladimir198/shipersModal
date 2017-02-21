<?php
include "db_params.php";
 $cnn = db_connect();
if ( isset($_POST["idArray"])) {
	foreach ($_POST["idArray"] as $ID ) {
				db_execute($cnn, "DELETE FROM Shippers WHERE [id]=".$ID );
	}
}

$con=null;
?>	