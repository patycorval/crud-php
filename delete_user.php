<?php
session_start();
include('session_control.php');
verificaSessao(); // Verifica se o usuário está logado

include('config.php');

if (isset($_GET['id'])) {
    $id = $_GET['id']; //id é atribuído à variável $id

    // Exclui o usuário do banco de dados
    $sql = "DELETE FROM usuarios WHERE id = ?";
    $stmt = $conn->prepare($sql); //repara a consulta para execução
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        echo "Usuário excluído com sucesso!";
        header("Location: index.php"); //redireciona p index
        exit();
    } else {
        echo "Erro ao excluir usuário!";
    }
} else {
    echo "ID inválido!";
    exit();
}
?>
