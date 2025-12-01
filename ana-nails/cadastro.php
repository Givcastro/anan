<?php
// ==========================
// Conexão com o banco
// ==========================
$host = "localhost";       // geralmente localhost
$user = "root";            // usuário do banco
$pass = "";                // senha do banco
$db   = "ananails";        // nome do banco de dados

$conexao = mysqli_connect($host, $user, $pass, $db);

if (!$conexao) {
    die("Erro ao conectar ao banco: " . mysqli_connect_error());
}

// ==========================
// Processamento do cadastro
// ==========================
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $nome  = mysqli_real_escape_string($conexao, $_POST["nome"]);
    $email = mysqli_real_escape_string($conexao, $_POST["email"]);
    $senha = $_POST["senha"];

    // Criptografa a senha
    $senha_hash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO usuario (Nome_usuario, Email, Senha, Tipo_usuario)
            VALUES ('$nome', '$email', '$senha_hash', 'Cliente')";

    if (mysqli_query($conexao, $sql)) {
        // Redireciona para o login do cliente após cadastro
        header("Location: login_cliente.html");
        exit();
    } else {
        echo "<p style='color:red;'>Erro ao cadastrar: " . mysqli_error($conexao) . "</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cadastro - Ana Nails</title>
    <style>
        body {
            font-family: 'Montserrat', sans-serif;
            background-color: #FFF5F9;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .form-container {
            background-color: #fff;
            padding: 40px 50px;
            border-radius: 12px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
            text-align: center;
        }

        .form-container h1 {
            color: #ff1493;
            margin-bottom: 25px;
        }

        .form-container input {
            width: 100%;
            padding: 12px 15px;
            margin: 10px 0;
            border-radius: 8px;
            border: 1px solid #ccc;
            font-size: 16px;
        }

        .form-container button {
            margin-top: 15px;
            padding: 12px 30px;
            background-color: #ff1493;
            color: #fff;
            border: none;
            border-radius: 25px;
            font-weight: 600;
            cursor: pointer;
            transition: 0.3s;
        }

        .form-container button:hover {
            background-color: #ff66b2;
        }

        .form-container a {
            display: block;
            margin-top: 15px;
            color: #ff1493;
            text-decoration: none;
        }

        .form-container a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Cadastro de Cliente</h1>
    <form method="POST" action="cadastro.php">
        <input type="text" name="nome" placeholder="Nome completo" required>
        <input type="email" name="email" placeholder="E-mail" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit">Cadastrar</button>
    </form>
    <a href="login_cliente.html">Já tem conta? Faça login</a>
</div>

</body>
</html>
