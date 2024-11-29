<?php
include('session_control.php');
verificaSessao(); // Verifica se o usuário está logado

include('config.php');

// Verifica se o usuário já aceitou os cookies
if (isset($_COOKIE['cookies_aceitos']) && $_COOKIE['cookies_aceitos'] == 'sim') {
    $cookie_aceito = true;
} else {
    $cookie_aceito = false;
}

$sql = "SELECT * FROM usuarios"; //busca todos os registros da tabela usuarios.
$result = $conn->query($sql); // guarda
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <title>Lista de Usuários</title>
    <link rel="stylesheet" href="css/style.css">
    <!-- Adiciona o Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
    <style>

        /* Estilo da barra de cookies */
        .cookie-banner {
            background-color: #333;
            color: #fff;
            position: fixed;
            bottom: 0;
            left: 0;
            width: 100%;
            padding: 15px;
            text-align: center;
            display: <?php echo $cookie_aceito ? 'none' : 'block'; ?>;
        }

    </style>
</head>
<body>
    
    <!-- Barra de cookies -->
    <div class="cookie-banner">
        <p class="cookie">Este site usa cookies para melhorar a sua experiência. Ao continuar navegando, você concorda com o uso de cookies.</p>
        <button onclick="aceitarCookies()">Aceitar</button>
    </div>

    <p><a href="logout.php" class="logout"><i class="fas fa-sign-out-alt"></i> Desconectar</a></p>


    <h1>Usuários Cadastrados</h1>

    <!-- Tabela com os usuários -->
    <table>
        <tr>
            <th>Nome</th>
            <th>Email</th>
            <th>Ações</th>
        </tr>
        <?php while ($user = $result->fetch_assoc()): ?> <!-- percorre os resultados retornados do banco -->
            <tr>
                <td><?php echo $user['nome']; ?></td>
                <td><?php echo $user['email']; ?></td>
                <td>
                    <!-- passa id via get -->
                    <a class="editar" href="edit_user.php?id=<?php echo $user['id']; ?>">Editar</a> |
                    <a class="excluir" href="delete_user.php?id=<?php echo $user['id']; ?>" onclick="return confirm('Tem certeza que deseja excluir?')">Excluir</a>
                </td>
            </tr>
        <?php endwhile; ?>
    </table>

    <!-- Botão de logout -->

    <script>
        // Função para aceitar os cookies e esconder a barra de aviso
        function aceitarCookies() {
            // Define um cookie para lembrar a escolha do usuário
            document.cookie = "cookies_aceitos=sim; max-age=" + 1*60 + "; path=/"; // Cookie expira em 1 min, um ano seria 365 * 24 * 60 * 60
            // Esconde a barra de cookies
            document.querySelector('.cookie-banner').style.display = 'none';
        }
    </script>
</body>
</html>
