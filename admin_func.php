<?php
require('connection.php');

function getAllWorkers() {
	require('connection.php');
	$res = $pdo->query("SELECT * FROM users WHERE roleId = 2");
	$result = $res->fetchAll(PDO::FETCH_ASSOC);
	var_dump($result);
	return $result;
}
?>