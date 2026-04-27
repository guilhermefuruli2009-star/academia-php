<?php

$dbname = 'academia_corpo_em_foco';
$host = 'localhost:4306';
$dbuser = 'root';
$dbpass = "";

try {
    $db = new PDO("mysql:dbname=" . $dbname . ";host=" . $host, $dbuser, $dbpass);
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro de conexão: " . $e->getMessage();
    exit();
}

define('BASE_URL', 'http://localhost/academia-php/');
define('ADMIN_URL', 'http://localhost/academia-php/admin/');
