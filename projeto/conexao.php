<?php

$host = 'localhost'; 
$db = 'agenda_propria'; 
$user = 'root';        
$pass = '';          


$conexao = new mysqli($host, $user, $pass, $db);

if ($conexao->connect_error) {

    die("Sem conexão. " . $conexao->connect_error);
}

?>