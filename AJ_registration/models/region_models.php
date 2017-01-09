<?php

include_once 'connect_db.php';

//доступ к базе данных

$link = mysql_connect(HOST, USER, PASS);
    if (!$link) {
        die('False to connect: ' . mysql_error());
	}

$selectDB = mysql_select_db($db); 
    if (!$selectDB) {
        die('False to select: ' . mysql_error());
	}

mysql_query("SET NAMES 'utf8'"); 
mysql_query("SET CHARACTER SET 'utf8'");
mysql_query("SET SESSION collation_connection = 'utf8_general_ci'");

//получение переменных из GET запроса

if ($_SERVER['REQUEST_METHOD'] == 'GET'){
	$model = $_GET['model'];
	if (isset($_GET['region'])) {
		$data = $_GET['region'];
	}
	else if (isset($_GET['city'])) {
		$data = $_GET['city'];
	}
	else {
		$data = "";
	}
}

//получение массива областей

function getRegion(){
	$selectRegion = "SELECT ter_address, reg_id FROM t_koatuu_tree WHERE ter_level = 1 ORDER BY ter_address ASC";
	$result = mysql_query ($selectRegion);
    if (!$result) {
		die('False to select: ' . mysql_error());
	}
	
	$array = array();
	while ($row = mysql_fetch_assoc($result)){
		array_push($array, $row['ter_address']);
	}
	
	return $array;
}

//получение массива городов

function getCity($region){
	$selectRegId = "SELECT reg_id FROM t_koatuu_tree WHERE ter_address = '$region'";
	$result = mysql_query ($selectRegId);
    if (!$result) {
		die('False to select: ' . mysql_error());
	}
	
	while ($row = mysql_fetch_assoc($result)){
		$reg_id = $row['reg_id'];
	}
	
	$selectCity = "SELECT ter_name FROM t_koatuu_tree WHERE ter_level = 2 AND ter_type_id = 1 AND reg_id = ". "$reg_id" ." ORDER BY ter_name ASC";
	$result = mysql_query ($selectCity);
    if (!$result) {
		die('False to select: ' . mysql_error());
	}
	
	$array = array();
	while ($row = mysql_fetch_assoc($result)){
		array_push($array, $row['ter_name']);
	}
	
	return $array;
}

//получение массива районов

function getDistrict($city){
	$selectTerId = "SELECT ter_id FROM t_koatuu_tree WHERE ter_name = '$city'";
	$result = mysql_query ($selectTerId);
    if (!$result) {
		die('False to select: ' . mysql_error());
	}
	
	while ($row = mysql_fetch_assoc($result)){
		$ter_id = $row['ter_id'];
	}
	
	$selectCity = "SELECT ter_name FROM t_koatuu_tree WHERE ter_level = 3 AND ter_type_id = 3 AND ter_pid = ". "$ter_id" ." ORDER BY ter_name ASC";
	$result = mysql_query ($selectCity);
    if (!$result) {
		die('False to select: ' . mysql_error());
	}
	
	$array = array();
	while ($row = mysql_fetch_assoc($result)){
		array_push($array, $row['ter_name']);
	}
	
	return $array;

}

//получение строки JSON

function parse($r){
	return json_encode($r);
}

echo parse($model($data));

?>