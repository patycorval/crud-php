<!-- conexão com o bd -->
<?php
$host = 'localhost';
$dbname = 'meu_banco';
$username = 'root';
$password = '';

$conn = new mysqli($host, $username, $password, $dbname); //nova instância do objeto mysqli para estabelecer a conexão com bd

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}
?>
