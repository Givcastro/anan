<?php
// Exibe erros para depuração
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
require 'conexao.php'; // conexão com banco 'ananails'

// Verifica se o usuário está logado
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login_cliente.php?redirect=agendamento.html");
    exit;
}

// Verifica se o ID do agendamento foi enviado
if (!isset($_GET['id'])) {
    $mensagem = "Agendamento não informado!";
    $tipo = "erro";
} else {
    $cliente_id = $_SESSION['usuario_id'];
    $agendamento_id = (int) $_GET['id'];

    // Remove o agendamento somente se pertencer ao cliente logado
    $stmt = $pdo->prepare("DELETE FROM agendamentos WHERE id_agendamento = :id AND cliente_id = :cliente");
    $stmt->execute([
        ':id' => $agendamento_id,
        ':cliente' => $cliente_id
    ]);

    if ($stmt->rowCount() > 0) {
        $mensagem = "Agendamento desmarcado com sucesso!";
        $tipo = "sucesso";
    } else {
        $mensagem = "Não foi possível desmarcar o agendamento.";
        $tipo = "erro";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Desmarcar Agendamento</title>
<link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;700&display=swap" rel="stylesheet">
<style>
    * {
        box-sizing: border-box;
        margin: 0;
        padding: 0;
        font-family: 'Roboto', sans-serif;
    }

    body {
        display: flex;
        justify-content: center;
        align-items: center;
        height: 100vh;
        background: #ffe6f2; /* ROSA BEBÊ */
    }

    .card {
        background: #fff;
        padding: 50px 30px;
        border-radius: 20px;
        box-shadow: 0 15px 35px rgba(0,0,0,0.2);
        text-align: center;
        max-width: 450px;
        width: 90%;
        animation: fadeIn 0.6s ease;
    }

    .card h2 {
        font-size: 28px;
        margin-bottom: 20px;
        color: #333;
    }

    .card p {
        font-size: 18px;
        margin-bottom: 40px;
        color: <?php echo ($tipo === "sucesso") ? "#28a745" : "#dc3545"; ?>;
        font-weight: 500;
    }

    .btn {
        display: inline-block;
        padding: 14px 30px;
        font-size: 16px;
        color: #fff;
        background: #ff6bb5;
        border-radius: 10px;
        text-decoration: none;
        font-weight: 600;
        transition: all 0.3s ease;
        box-shadow: 0 8px 20px rgba(255, 107, 181, 0.4);
    }

    .btn:hover {
        background: #ff49a0;
        transform: translateY(-3px);
        box-shadow: 0 12px 25px rgba(255, 107, 181, 0.5);
    }

    .btn:active {
        transform: translateY(1px);
        box-shadow: 0 5px 15px rgba(255, 107, 181, 0.4);
    }

    @keyframes fadeIn {
        from {opacity: 0; transform: translateY(-20px);}
        to {opacity: 1; transform: translateY(0);}
    }

    @media(max-width: 500px) {
        .card {
            padding: 40px 20px;
        }
        .card h2 {
            font-size: 24px;
        }
        .card p {
            font-size: 16px;
        }
    }
</style>
</head>
<body>
    <div class="card">
        <h2>Desmarcar Agendamento</h2>
        <p><?php echo $mensagem; ?></p>
        <a href="telaservicos.html" class="btn">Voltar para serviços</a>
    </div>
</body>
</html>
