<?php

include('config.php');
include('session_control.php'); //Gerencia a autenticação e sessões, tem session_start()
include('cookies_control.php');

// Verifica se há uma mensagem de sucesso na URL e a exibe
if (isset($_GET['sucesso'])) {
    echo "<p class='sucesso'>" . $_GET['sucesso'] . "</p>";
}

// cod executado somente se o formulário for enviado via POST e o botão de login for clicado.
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['login'])) {
        // Processa o login
        $email = $_POST['email'];
        $senha = $_POST['senha'];

        //Realiza uma consulta SQL para buscar o usuário pelo email.
        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            if (password_verify($senha, $user['senha'])) { //Compara a senha inserida com o hash armazenado no banco (usado na função password_hash() no cadastro).
                $_SESSION['usuario_logado'] = $user['email']; //armazena email na sessao
                controleCookies(); // Define cookies se necessário
                header("Location: index.php");
                exit();
            } else {
                echo "<p class='erro'>Usuário ou senha incorretos!</p>";
            }
        } else {
            echo "<p class='erro'>Usuário ou senha incorretos!</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Login</h1>
    <form method="POST">
        <label>Usuário: <input type="email" name="email" required></label><br>
        <label>Senha: <input type="password" name="senha" required></label><br>
        <button type="submit" name="login">Entrar</button>
    </form>

    <p>Ainda não tem uma conta? <a href="cadastro.php">Cadastre-se aqui</a>.</p>
</body>
</html>

