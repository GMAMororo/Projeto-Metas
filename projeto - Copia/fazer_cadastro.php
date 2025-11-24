<?php
mysqli_report(MYSQLI_REPORT_OFF);

require_once 'conexao.php'; 


//Verifica se o cadastro foi enviado pelo metodo POST pra manter segurança dos dados
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    // Recebe e limpa os dados do cadastro
    $username = $conexao->real_escape_string($_POST['username']);
    $senha_limpa = $_POST['senha'];


    // Parte da criptografia por password_hash
    $password_hashed = password_hash($senha_limpa, PASSWORD_DEFAULT);


    $sql = "INSERT INTO usuarios (username, senha) VALUES (?, ?)";


    if ($stmt = $conexao->prepare($sql)) {
        

        $stmt->bind_param("ss", $username, $password_hashed);
        

        if ($stmt->execute()) {

        header("Location: login.php?sucesso=cadastro");

            exit();
        } else {

        header("Location: cadastro.php?erro=duplicata");
        }
        
        $stmt->close();
    } else {
        header("Location: cadastro.php?erro=desconhecido");
    }
}
$conexao->close(); 
?>