<?php

$host = 'localhost'; 
$user = 'root';      
$pass = '';      
$db = 'agenda_propria';    
$conexao_temp = new mysqli($host, $user, $pass);
$conexao_temp->query("CREATE DATABASE IF NOT EXISTS agenda_propria");
$conexao_temp->close();

$conexao = new mysqli($host, $user, $pass, $db);

if ($conexao->connect_error) {
    die("Sem conexão. " . $conexao->connect_error);
}
    

$sql_users = "CREATE TABLE IF NOT EXISTS usuarios(
    Id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    username VARCHAR(50) NOT NULL UNIQUE,
    senha VARCHAR(255) NOT NULL
)";
$conexao->query($sql_users);


$sql_events = "CREATE TABLE IF NOT EXISTS events (
    id INT NOT NULL PRIMARY KEY AUTO_INCREMENT,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    start DATETIME NOT NULL,
    end DATETIME DEFAULT NULL,
    user_id INT NOT NULL
)";
$conexao->query($sql_events);


?>