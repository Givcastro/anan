<?php
session_start();
include "conexao.php";

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql = $conn->query("SELECT * FROM USUARIO WHERE Email='$email' AND Senha='$senha'");

if($sql->num_rows == 1){
    $cliente = $sql->fetch_assoc();
    $_SESSION['cliente_id'] = $cliente['Cod_usuario'];

    header("Location: painel_cliente.php");
    exit();
} else {
    echo "<script>alert('Usuário ou senha incorretos!'); window.location='login_cliente.php';</script>";
}
?>
