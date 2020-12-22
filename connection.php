<?php
$host = 'dz'; // адрес сервера 
$database = 'dz_polieftov'; // имя базы данных
$user = 'root'; // имя пользователя
$password = 'root'; // пароль
$dsn = "mysql:host=$host;dbname=$database;charset=utf8";
$opt = [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION];
$pdo = new PDO($dsn, $user, $password, $opt);

?>