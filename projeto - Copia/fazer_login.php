<?php
session_start();
require_once 'conexao.php'; 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = $conexao->real_escape_string($_POST['username']);
    $senha_digitada = $_POST['senha'];

    $sql = "SELECT id, senha FROM usuarios WHERE username = ?";

    if ($stmt = $conexao->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $resultado = $stmt->get_result(); 

        if ($resultado->num_rows === 1) {
            $usuario = $resultado->fetch_assoc();
            $hash_armazenado = $usuario['senha']; 

            if (password_verify($senha_digitada, $hash_armazenado)) {
                
                $_SESSION['user_id'] = $usuario['id'];
                $_SESSION['username'] = $username;
                $_SESSION['logado'] = TRUE;
                

                header("Location: calendario.php");
                exit();
            }
        }
        
        header("Location: login.php?erro=credenciais_invalidas");
        exit();

        $stmt->close();
    } else {
        header("Location: login.php?erro=desconhecido");

    }
}
$conexao->close();
?>