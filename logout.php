<?php
session_start();
session_unset(); //Remove todas as variáveis de sessão.
session_destroy();//  Destroi a sessão ativa no servidor
setcookie('usuario', '', time() - 3600, "/"); // Limpa o cookie
header("Location: login.php");
exit(); //Garante que o script seja encerrado imediatamente após o redirecionamento.
?>
