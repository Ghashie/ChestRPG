<?php
if (!isset($_SESSION)) session_start();

// Destruir a sessão
session_destroy();

// Redirecionar para a página de login ou qualquer outra página desejada
header("Location: loginUser.php");

?>
