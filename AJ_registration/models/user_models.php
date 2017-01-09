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
	if (isset($_POST['login'])) {
		$login = $_POST['login'];
	}
	if (isset($_POST['email'])) {
		$email = $_POST['email'];
	}
	if (isset($_POST['region'])) {
		$region = $_POST['region'] !== "" ? $_POST['region'] : "NULL";
	}
	$city = isset($_POST['city']) ? $_POST['city'] : "NULL";
	$district = isset($_POST['district']) ? ($_POST['district'] !== "" ? $_POST['district'] : "NULL") : "NULL";
	
	if (isset($_POST['model'])) {
		$userModel = $_POST['model'];
	}
}

//создание таблицы пользователей

function createTable(){
	$users = "CREATE TABLE IF NOT EXISTS users (
											id INT NOT NULL AUTO_INCREMENT,
											login varchar(50) NOT NULL,
											email varchar(50) NOT NULL,
											region varchar(50) NOT NULL,
											city varchar(50) NOT NULL,
											district varchar(50) NOT NULL,
											date DATETIME,
											PRIMARY KEY (id)
											) 
											CHARACTER SET utf8 COLLATE utf8_unicode_ci";
	mysql_query ($users) or die('False to create: ' . mysql_error());
}

//createTable();

//добавление пользователей в таблицу

function addUser($login, $email, $region, $city, $district){
    $addUser = "INSERT INTO users (
    							login, 
    							email, 
    							region, 
    							city,
    							district,
    							date
    							) 
    						VALUES (
    							'$login', 
    							'$email', 
    							'$region', 
    							'$city',
    							'$district',
    							NOW()
    							)"; 
    mysql_query($addUser) or die ('False to insert: ' . mysql_error());
}

$userModel($login, $email, $region, $city, $district);

?>