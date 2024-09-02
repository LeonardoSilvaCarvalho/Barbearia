<?php
$dsn = 'mysql:host=localhost;dbname=barbearia';
$user = 'root';
$pass = 'Bb&1101010';
$option = array(
	PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'
);
try {
	$con = new PDO($dsn, $user, $pass, $option);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	//echo 'Bom, muito bom !';
} catch (PDOException $ex) {
	echo "Falha ao conectar-se ao banco de dados! " . $ex->getMessage();
	die();
}
