<?php
$host = 'localhost'; $dbname = 'practical15'; $username = 'root'; $password = '';
try {
$pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password, [
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES => false
]);
} catch (PDOException $e) {
http_response_code(500);
exit('Database connection failed. Import schema.sql in phpMyAdmin and check db.php settings.');
}
