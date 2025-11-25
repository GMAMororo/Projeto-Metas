<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="style.css">

    <title>Cadastro</title>

</head>
<body class='centralizar'>
    <div class='container'>
    <h2>Cadastre-se</h2>


    <form action="fazer_cadastro.php" method="POST">


    <label>Nome de Usuário
    <input type="text" id="username" name="username" required><br><br>
</label><br>
    <label>Senha:</label><br>
    <input type="password" id="senha" name="senha" required><br><br>

    <button type="submit" class='form-submit-btn'>Cadastrar</button>

</form>
<br><a href="index.php" class='form-voltar-btn'>⭠</a>
</div>
<?php

if (isset($_GET['erro'])) {
    $codigo_erro = $_GET['erro'];

    if ($codigo_erro === 'duplicata') {
    echo '<script>alert("Usuário utilizado ja existe, tente outro.")</script>';        

    } else if ($codigo_erro === 'desconhecido') {
    echo '<script>alert("Erro Desconhecido ocorreu.")</script>';    }
}



?>
</body>
</html>