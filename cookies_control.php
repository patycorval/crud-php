<?php
function controleCookies() {
    // Define um cookie para lembrar o usuário por 1 min
    if (!isset($_COOKIE['usuario'])) { //Verifica se o cookie usuario já existe
        setcookie('usuario', $_SESSION['usuario_logado'], time() + (1*60), "/"); 
        //nome cookie, valor armazenado, 1 min, valido p tds as pags
    }
}
?>
