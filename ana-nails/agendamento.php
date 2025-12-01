<?php
session_start();
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Agendamento - Ana Nails</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body { font-family: Arial, sans-serif; background: #f2f2f2; }
        .container { max-width: 400px; margin: 50px auto; background: #fff; padding: 20px; border-radius: 10px; box-shadow: 0 2px 8px rgba(0,0,0,0.2); }
        h1 { text-align: center; color: #d63384; }
        input, select, button { width: 100%; padding: 10px; margin: 10px 0; border-radius: 5px; border: 1px solid #ccc; }
        button { background-color: #d63384; color: #fff; border: none; cursor: pointer; font-weight: bold; }
        button:hover { background-color: #c11269; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Agendamento</h1>
        <form action="confirmacao.php" method="POST">
            <label>Nome:</label>
            <input type="text" name="nome" required>

            <label>Serviço:</label>
            <select name="servico" required>
                <option value="Manicure">Manicure</option>
                <option value="Pedicure">Pedicure</option>
                <option value="Alongamento de unhas">Alongamento de unhas</option>
            </select>

            <label>Data:</label>
            <input type="date" name="data" required>

            <label>Horário:</label>
            <input type="time" name="horario" required>

            <button type="submit">Confirmar horário</button>
        </form>
    </div>
</body>
</html>
