<?php

$config = require './config.inc.php';

try {
	$db = new PDO("mysql:host={$config['db_host']};dbname={$config['db_name']}", $config['db_user'], $config['db_pass']);
	$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
	$db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
	// $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
	return $db;
} catch(PDOException $err) {
	echo "<h1>MySQL Error:</h1>";
	var_dump($err->getMessage());
}
