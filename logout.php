<?php
    session_start(); // Inicia a sessão (se ainda não estiver iniciada)
    session_destroy(); // Destrói a sessão
    header("Location: index.php"); // Redireciona para a página de login ou para a página inicial
    exit();
?>
