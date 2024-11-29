<?php
include('config.php');

//pega dados do forms
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $nome = $_POST['nome'];
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Verifica se o e-mail já está cadastrado
    $sql = "SELECT * FROM usuarios WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email); //substitui o ? pelo valor de $email, s de string
    $stmt->execute(); //executa consulta
    $result = $stmt->get_result(); //obtem resultado

    if ($result->num_rows > 0) {
        echo "<p class='erro'> Este e-mail já está cadastrado! </p>";
    } else {
        // Criptografa a senha
        $senha_hash = password_hash($senha, PASSWORD_DEFAULT); //sa o algoritmo mais seguro disponível (atualmente bcrypt).

        // Insere o novo usuário
        $sql = "INSERT INTO usuarios (nome, email, senha) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($sql); //preparar a consulta SQL, evita injeções de SQL
        $stmt->bind_param("sss", $nome, $email, $senha_hash);//  vincula parâmetros 

        if ($stmt->execute()) { //se a inserção for bem sucedida
            // Redireciona para a página de login com a mensagem de sucesso
            header("Location: login.php?sucesso=Cadastro realizado com sucesso! Faça seu login.");
            exit();
        } else {
            echo "<p class='erro'>Erro ao cadastrar usuário!</p>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Cadastro</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Cadastro</h1>
    <form method="POST">
        <label>Nome: <input type="text" name="nome" required></label><br>
        <label>E-mail: <input type="email" name="email" required></label><br>
        <label>Senha: <input type="password" name="senha" required></label><br>
        <button type="submit">Cadastrar</button>
    </form>

    <p>Já tem uma conta? <a href="login.php">Faça login aqui</a>.</p>
</body>
</html>

