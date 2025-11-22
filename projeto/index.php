<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<?php

require_once 'conexao.php';

?>

    <title>Metas do Cotidiano</title>
</head>


<body>
    <h1>Bem vindo ao site Ritmo Proprio</h1>
  <p>Já tem uma conta?</p>  <a href="login.php">Login</a> 


   <p>Não tem uma conta?</p> <a href="cadastro.php">Cadastre-se aqui</a>
</body>
<?php 

        if (isset($status_conexao)) {
            echo $status_conexao;
        }
?>


</html>