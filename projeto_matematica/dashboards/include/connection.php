<?php 
define('host', 'localhost');
define('database_name', 'projeto');
define('user', 'root');
define('password', '');

try{
    $pdo = new PDO("mysql:host=" . host . ";dbname=" . database_name . ";charset=utf8", user, password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
}

catch(PDOException $e){
    error_log($e->getMessage());
    die("Erro de conexão com o banco de dados.");
}

?>