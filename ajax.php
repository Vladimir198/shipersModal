 <?php 
 include "db_params.php";
 $cnn = db_connect();
 $rs = db_execute($cnn, "select * from Shippers");

 while (!$rs->EOF) {
 	?>
 	<tr id=<?php echo $rs->Fields["id"]->Value; ?> class="active" onclick=<?php echo "rowClick(". $rs->Fields["id"]->Value.")" ?>>
 		<td><?php echo $rs->Fields["Name"]->Value; ?></td>
 		<td><?php echo $rs->Fields["Adress"]; ?></td>
 	</tr>
 	<?php
 	$rs->MoveNext(); 
 } 
 $con = $rs=null;
 ?>