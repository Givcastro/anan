<?php
session_start();
require "conexao.php"; // <-- precisa existir e criar $conexao corretamente

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $nome  = trim($_POST["nome"]);
    $email = trim($_POST["email"]);
    $senha = trim($_POST["senha"]);

    $senhaHash = password_hash($senha, PASSWORD_DEFAULT);

    $sql = "INSERT INTO ADMIN (nome, email, senha) VALUES (?, ?, ?)";
    $stmt = mysqli_prepare($conexao, $sql);

    if (!$stmt) {
        die("Erro na preparação da query: " . mysqli_error($conexao));
    }

    mysqli_stmt_bind_param($stmt, "sss", $nome, $email, $senhaHash);

    if (mysqli_stmt_execute($stmt)) {
        header("Location: loginadm.php"); // <-- redireciona para a página correta
        exit();
    } else {
        $erro = "Erro ao cadastrar: " . mysqli_error($conexao);
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Cadastro Administrador</title>
<link rel="stylesheet" href="style_adm.css">
</head>
<body>

<h2>Cadastrar Administrador</h2>

<?php if (isset($erro)) echo "<p class='error'>$erro</p>"; ?>

<form method="POST">
    <input type="text" name="nome" placeholder="Nome" required>
    <input type="email" name="email" placeholder="Email" required>
    <input type="password" name="senha" placeholder="Senha" required>
    <button type="submit">Cadastrar</button>
</form>

<p><a href="loginadm.php">Já tenho login</a></p>

</body>
</html>
