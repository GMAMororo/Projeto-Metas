<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">

<title>Login</title>

</head>
<body>
    <h2>Entrar</h2>

    <form action="fazer_login.php" method="post">
        <label>Nome de usuário:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label>Senha:</label><br>
        <input type="password" id="senha" name="senha" required><br><br>

        <button type="submit">Entrar</button>
    </form>

    <br><a href="index.php">Voltar</a>
<?php
if (isset($_GET['erro'])) {
    $codigo_erro = $_GET['erro'];

    if ($codigo_erro === 'credenciais_invalidas') {
    echo '<script>alert("Nome de Usuario ou Senha incorretas, tente novamente!!!.")</script>';        

    } else if ($codigo_erro === 'desconhecido') {
    echo '<script>alert("Erro Desconhecido ocorreu.")</script>';    }
}
?>

</body>
</html>