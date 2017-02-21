<?php
//require_once("params.php");
$db_server = "DESKTOP-18C7A6J";
$db_database = "lsort";
$db_user = "sa";
$db_password = "a-vektor";

$cnn_str="Provider=SQLOLEDB; Data Source=".$db_server."; Initial Catalog=".$db_database."; User ID=".$db_user."; Password=".$db_password;

//require_once("error_handler.php");

function db_get_error_msg($cnn){
	$err_str="";
	for($i=0; $i<$cnn->Errors->Count; $i++){
		$err_str.=$cnn->Errors[$i]->Description."\r\n";
	}
	return $err_str;
}

function db_connect(){
	global $cnn_str;
	try{
		$cnn = new COM("ADODB.Connection",null,CP_UTF8);
	}catch(Exception $e){
		trigger_error("Database ADO init failed!\r\nError: Cannot start ADO!");
		return false;
	}

	$timeout = 15*60;
	set_time_limit($timeout);
	$cnn->CommandTimeout = $timeout;

	try{
		$cnn->Open($cnn_str);
	}catch(Exception $e){
		trigger_error("Database connection failed!\r\nConnectionString: $cnn_str\r\nError: ".db_get_error_msg($cnn));
		return false;
	}
	return $cnn;
}

function db_execute($cnn,$query){
	try{
		return $cnn->Execute($query);
	}catch(Exception $e){
		trigger_error("Database query failed!\r\nQuery: $query\r\nError: ".db_get_error_msg($cnn));
		return false;
	}
}

function db_check_str_param($param){
	$s = str_replace("'", "''", $param);
	return $s;
}

function db_check_int_param($param,$min=null,$max=null){
	$x=intval($param);
	if($min!=null && $x<$min) $x=$min;
	if($max!=null && $x>$max) $x=$max;
	return $x;
}

function db_check_float_param($param,$min=null,$max=null){
	$x=floatval($param);
	if($min!=null && $x<$min) $x=$min;
	if($max!=null && $x>$max) $x=$max;
	return $x;
}

function db_check_boolean_param($param){
	if(!is_bool($param)){
		$param=strtolower((string)$param);
		if($param=="1"||$param=="true") $param=true; else $param=false;
	}
	return ($param ? "1":"0");
}

function db_check_date_param($param){
	$t=strtotime($param);
	if(!$t) $t=time();
	return date("Ymd",$t);
}

function db_check_datetime_param($param){
	$t=strtotime($param);
	if(!$t) $t=time();
	return date("'Y-m-d H:i:s'",$t);
}

function db_check_form(&$data, &$form){
	foreach($form as $itemName => $item){
		switch($item['type']){
		case "integer":
			$data[$itemName]['value']=db_check_int_param($data[$itemName]['value'], $item['min'], $item['max']);
			break;
		case "float":
			$data[$itemName]['value']=db_check_float_param($data[$itemName]['value'], $item['min'], $item['max']);
			break;
		case "boolean":
			$data[$itemName]['value']=db_check_boolean_param($data[$itemName]['value']);
			break;
		case "string":
			$data[$itemName]['value']=db_check_str_param($data[$itemName]['value']);
			break;
		}
	}
}

//$server_ip = $udp_server_ip;
//$server_port = $udp_port;

function CheckUDPPort(){
    global $server_port, $server_ip;

    $timeout = 2;
    $string = 'check';

    $fp = fsockopen('udp://'.$server_ip, $server_port);
    socket_set_timeout($fp, $timeout);
    fwrite($fp, $string);

    $result = fread($fp, 18);
    fclose($fp);
    return $result;
}

function SendMessageToLsort($message){
    global $server_port, $server_ip;

    $timeout = 2;
    $socket = fsockopen('udp://'.$server_ip, $server_port);

    if ($socket){

        socket_set_timeout($socket, $timeout);
        $result_write = fwrite($socket, $message);
        if ($result_write) $result_read = fread($socket, 18);

    }

    if (isset($socket)) fclose($socket);

    return $result_read;
}

?>
