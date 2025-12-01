<?php
session_start();
require "conexao.php";

if (!isset($_POST['email'], $_POST['senha'])) {
    die("Requisição inválida.");
}

$email = $_POST['email'];
$senha = $_POST['senha'];

try {
    $stmt = $conn->prepare("SELECT * FROM admin WHERE email = :email LIMIT 1");
    $stmt->bindParam(":email", $email);
    $stmt->execute();

    if ($stmt->rowCount() === 1) {
        $adm = $stmt->fetch(PDO::FETCH_ASSOC);

        if (password_verify($senha, $adm['senha'])) {

            $_SESSION['admin_id'] = $adm['id'];
            $_SESSION['admin_nome'] = $adm['nome'];

            // REDIRECIONAR PARA A AGENDA DO ADMIN
            header("Location: agenda_adm.php");
            exit;
        }
    }

    echo "❌ Email ou senha incorretos.";
} 
catch (PDOException $e) {
    echo "Erro: " . $e->getMessage();
}
