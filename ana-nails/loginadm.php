<?php
session_start();


$conn = new mysqli("localhost","root","","ananails");
if ($conn->connect_error) die("Conexão falhou: " . $conn->connect_error);

if(isset($_POST['entrar'])){
    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Corrigido: tabela ADMIN usa 'email', 'senha' e 'id'
    $sql = "SELECT * FROM ADMIN WHERE email = ?";
    $stmt = $conn->prepare($sql);

    if(!$stmt){
        die("Erro na query: " . $conn->error);
    }

    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if($result->num_rows > 0){
        $admin = $result->fetch_assoc();

        // Verifica senha correta
        if(password_verify($senha, $admin['senha'])){
            
            // Salva sessão usando as COLUNAS CORRETAS
            $_SESSION['admin_id']   = $admin['id'];     // CORREÇÃO
            $_SESSION['admin_nome'] = $admin['nome'];   // CORREÇÃO

            header("Location: agenda_adm.php");  // sua página desejada
            exit();

        } else {
            $erro = "Senha incorreta!";
        }
    } else {
        $erro = "Administrador não encontrado!";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Login Administrador</title>
<link rel="stylesheet" href="style_adm.css">
</head>
<body>

<header>Área do Administrador</header>

<div class="container">
    <h2>Login</h2>
    <?php if(isset($erro)) echo "<p class='error'>$erro</p>"; ?>
    
    <form method="POST">
        <input type="email" name="email" placeholder="Email" required>
        <input type="password" name="senha" placeholder="Senha" required>
        <button type="submit" name="entrar">Entrar</button>
    </form>
    
    <a href="cadastro_adm.php">Criar conta de Administrador</a>
</div>

</body>
</html>
