
<?php

session_start();
require 'conexao.php'; // conexão com banco 'ananails'

// Verifica se o cliente está logado
if (!isset($_SESSION['cliente_logado'])) {
    header("Location: login_cliente.php?redirect=painel_cliente.php");
    exit;
}

$cliente_id = $_SESSION['cliente_logado'];

// Busca os agendamentos do cliente
$stmt = $pdo->prepare("SELECT * FROM agendamentos WHERE cliente_id = :id ORDER BY data, hora");
$stmt->execute(['id' => $cliente_id]);
$agendamentos = $stmt->fetchAll();
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <title>Painel do Cliente</title>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: #fff0f5;
            color: #333;
            margin: 0;
            padding: 0;
        }
        header {
            background-color: #ff4fa5;
            padding: 20px;
            text-align: center;
            color: white;
            font-size: 24px;
            font-weight: 700;
        }
        .container {
            max-width: 800px;
            margin: 40px auto;
            padding: 0 20px;
        }
        h2 {
            color: #ff4fa5;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
            background: white;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        th, td {
            padding: 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }
        th {
            background-color: #ff4fa5;
            color: white;
        }
        a.desmarcar {
            background-color: #2980b9;
            color: white;
            padding: 8px 15px;
            border-radius: 8px;
            text-decoration: none;
            font-weight: 600;
            transition: 0.3s;
        }
        a.desmarcar:hover {
            background-color: #1f5d8a;
        }
        .sem-agendamentos {
            text-align: center;
            margin-top: 20px;
            padding: 20px;
            background: #fff1fa;
            border-radius: 12px;
            font-weight: 600;
            color: #555;
        }
    </style>
</head>
<body>

<header>
    Olá, <?= htmlspecialchars($_SESSION['cliente_nome']) ?> — Seus Agendamentos
</header>

<div class="container">

    <?php if(count($agendamentos) === 0): ?>
        <div class="sem-agendamentos">Você não possui agendamentos.</div>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Serviço</th>
                    <th>Data</th>
                    <th>Hora</th>
                    <th>Ação</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach($agendamentos as $a): ?>
                    <tr>
                        <td><?= htmlspecialchars($a['servico']) ?></td>
                        <td><?= $a['data'] ?></td>
                        <td><?= $a['hora'] ?></td>
                        <td>
                            <a href="desmarcar.php?id=<?= $a['id'] ?>" onclick="return confirm('Deseja realmente desmarcar este agendamento?')" class="desmarcar">Desmarcar</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>

</div>

</body>
</html>
