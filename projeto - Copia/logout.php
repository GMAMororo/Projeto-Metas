<?php
session_start();       // 1. Acessa a sessão atual
session_destroy();     // 2. Destrói todos os dados da sessão (a "pulseira")
header("Location: index.php"); // 3. Manda o usuário para a tela de login
exit;
?>