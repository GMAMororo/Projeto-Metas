<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>

</head>
<body>
    <h2>Cadastre-se</h2>


    <form action="fazer_cadastro.php" method="POST">


    <label>Nome de Usuário:</label><br>
    <input type="text" id="username" name="username" required><br><br>

    <label>Senha:</label><br>
    <input type="password" id="senha" name="senha" required><br><br>

    <button type="submit">Cadastrar</button>

</form>
<br><a href="index.php">Voltar</a>
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