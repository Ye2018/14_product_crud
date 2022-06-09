<?php
// two ways to make a database connection. One is mysqli, the other is pdo
// pdo support multiple databases and OOP
$pdo = new PDO('mysql:host=localhost;port=3306;dbname=products_crud','root',''); // the third paramter is password. For windows, it is empty
$pdo -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// return $pdo;
?>