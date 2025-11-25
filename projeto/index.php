<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="assets/style.css">
<?php

require_once 'config/conexao.php';

?>

    <title>Metas do Cotidiano</title>
</head>


<body class='centralizar'>
<div class="container">
    <img src="https://freesvg.org/img/Anonymous_target_with_arrow.png" class="logo">
    <h1>Bem vindo ao site Ritmo Proprio</h1>


<a href="login.php" class="lobby-btn" >Login</a> 


<a href="cadastro.php" class="lobby-btn">Cadastre-se aqui</a>
</div>

</body>


<?php 

        if (isset($status_conexao)) {
            echo $status_conexao;
        }
?>


</html>