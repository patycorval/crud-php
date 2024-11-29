<?php
include('session_control.php');
verificaSessao(); // Verifica se o usuário está logado

include('config.php');

if (isset($_GET['id'])) { //Verifica se o parâmetro id foi enviado via GET
    $id = $_GET['id'];

    // Busca o usuário no banco de dados
    $sql = "SELECT * FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc(); //dados armazenados em $user como um array associativo.
    } else {
        echo "Usuário não encontrado!";
        exit();
    }

    // Atualização de dados
    if ($_SERVER['REQUEST_METHOD'] == 'POST') {
        $nome = $_POST['nome'];
        $email = $_POST['email'];

        // Verifica se foi fornecida uma nova senha
        if (!empty($_POST['senha'])) {
            $senha = $_POST['senha'];
            // Criptografa a nova senha
            $senha_hash = password_hash($senha, PASSWORD_DEFAULT);
            $sql = "UPDATE usuarios SET nome = ?, email = ?, senha = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("sssi", $nome, $email, $senha_hash, $id);
        } else {
            // Se não foi fornecida senha, atualiza apenas nome e email
            $sql = "UPDATE usuarios SET nome = ?, email = ? WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssi", $nome, $email, $id);
        }

        if ($stmt->execute()) { //se a consulta for bem suce
            echo "Cadastro atualizado com sucesso!";
            header("Location: index.php");
            exit();
        } else {
            echo "Erro ao atualizar cadastro!";
        }
    }
} else {
    echo "ID inválido!";
    exit();
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Editar Cadastro</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Editar Cadastro</h1>
    <form method="POST">
        <label>Nome: <input type="text" name="nome" value="<?php echo $user['nome']; ?>" required></label><br>
        <label>Email: <input type="email" name="email" value="<?php echo $user['email']; ?>" required></label><br>
        <button type="submit">Atualizar</button>
    </form>
    <p><a href="index.php">Voltar para a lista de usuários</a></p>
</body>
</html>
