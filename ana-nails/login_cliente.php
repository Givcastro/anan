<?php
session_start();
include("conexao.php");

// Verifica se o formulário enviou os dados
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $email = $_POST['email'];
    $senha = $_POST['senha'];

    // Prepara consulta
    $query = "SELECT Cod_usuario, Nome_usuario, Senha FROM usuario WHERE Email = ?";
    $stmt = mysqli_prepare($conexao, $query);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);

    $resultado = mysqli_stmt_get_result($stmt);

    if ($resultado && mysqli_num_rows($resultado) === 1) {

        $usuario = mysqli_fetch_assoc($resultado);

        // Verifica a senha
        if (password_verify($senha, $usuario['Senha'])) {

            $_SESSION['usuario_id'] = $usuario['Cod_usuario'];
            $_SESSION['nome_usuario'] = $usuario['Nome_usuario'];

            // AGORA VAI PARA A TELA DE SELEÇÃO DE SERVIÇOS
            header("Location: telaservicos.html");
            exit();
        } else {
            echo "<script>alert('Senha incorreta!'); window.location.href='login_cliente.html';</script>";
        }
    } else {
        echo "<script>alert('Usuário não encontrado!'); window.location.href='login_cliente.html';</script>";
    }
}
?>
