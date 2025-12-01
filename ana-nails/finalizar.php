<?php
$servico = $_POST['servico'] ?? '';
$data    = $_POST['data'] ?? '';
$hora    = $_POST['hora'] ?? '';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento Finalizado</title>

    <style>
        body {
            background: linear-gradient(135deg, #ffe6f0 0%, #ffffff 100%);
            font-family: "Poppins", sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 480px;
            margin: 90px auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 22px;
            box-shadow: 0 12px 30px rgba(0,0,0,0.12);
            text-align: center;
            animation: fadeIn .6s ease;
        }

        h2 {
            color: #C2185B;
            font-size: 28px;
            margin-bottom: 25px;
        }

        p {
            font-size: 18px;
            color: #444;
            line-height: 1.7;
        }

        .btn {
            margin-top: 30px;
            display: inline-block;
            padding: 14px 28px;
            background: #C2185B;
            color: white;
            text-decoration: none;
            border-radius: 16px;
            font-size: 18px;
            font-weight: 600;
            transition: .2s ease;
            box-shadow: 0 8px 20px rgba(194,24,91,.3);
        }

        .btn:hover {
            background: #a01048;
            transform: scale(1.03);
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(10px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>

</head>

<body>

<div class="container">
    <h2>Agendamento Confirmado! ✅</h2>

    <p><strong>Serviço:</strong> <?= htmlspecialchars($servico) ?></p>
    <p><strong>Data:</strong> <?= htmlspecialchars($data) ?></p>
    <p><strong>Horário:</strong> <?= htmlspecialchars($hora) ?></p>

    <a href="home.html" class="btn">Voltar ao início</a>
</div>

</body>
</html>
