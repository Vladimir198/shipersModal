 <?php 
 include "db_params.php";
 $cnn = db_connect();
 $rs = db_execute($cnn, "select * from Shippers");
/**
* 
*/
$array  = array();
$i=0;
 while (!$rs->EOF) {
 	$array[i]->id = $rs->Fields["id"]->Value;
 	$array[i]->name = $rs->Fields["Name"]->Value;
 	$array[i++]->adress = $rs->Fields["Adress"]->Value;
 	$rs->MoveNext();
 	
 } 
 $con = $rs=null;
 ?>
 <!-- <tr id=<?php echo $rs->Fields["id"]->Value; ?> class="active" onclick=<?php echo "rowClick(". $rs->Fields["id"]->Value.")" ?>>
 		<td><?php echo $rs->Fields["Name"]->Value; ?></td>
 		<td><?php echo $rs->Fields["Adress"]; ?></td>
 	</tr> -->