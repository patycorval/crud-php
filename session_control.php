<?php
session_start();

function verificaSessao() {
    //A chave usuario_logado em $_SESSION deve ser definida durante o login do usuário.
    if (!isset($_SESSION['usuario_logado'])) { //Verifica se o usuário não está logado.
        header("Location: login.php");
        exit(); //Garante que o restante do script não seja executado após o redirecionamento
    }
}
?>
