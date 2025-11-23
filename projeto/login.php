<!DOCTYPE html>
<html lang="pt-br">
<head>
<meta charset="UTF-8">
<link rel="stylesheet" href="style.css">

<title>Login</title>

</head>
<body>
    <div class='container'>
    <h1>Entrar</h1>

    <form action="fazer_login.php" method="post">
        <label>Nome de usuário:</label><br>
        <input type="text" id="username" name="username" required><br><br>

        <label>Senha:</label><br>
        <input type="password" id="senha" name="senha" required><br><br>

        <button type="submit" class='form-submit-btn'>Entrar</button>
    </form>
    <br><a href="index.php" class='form-voltar-btn'>⭠</a>
</div>
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