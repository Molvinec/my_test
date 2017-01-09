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

//получение переменных из POST запроса

if ($_SERVER['REQUEST_METHOD'] == 'POST'){
	if (isset($_POST['email'])) {
		$email = $_POST['email'];
	}
	if (isset($_POST['model'])) {
		$model = $_POST['model'];
	}
}

//проверка email

function verification($data){
    $emailVerif = "SELECT email FROM users WHERE email = '$data'";
	$result = mysql_query($emailVerif);
	
	if (!$result) {
		die('False to select: ' . mysql_error());
	}
	while ($row = mysql_fetch_assoc($result)){
		$userEmail = $row['email'];
	}
	if (isset ($userEmail)){
		return true;
	}
	else {
		return false;
	}
}

//получение строки JSON

function parse($r){
	return json_encode($r);
}

echo parse($model($email));

?>