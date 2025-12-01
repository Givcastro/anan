<?php
// Garantir que os dados vieram via POST
$servico = isset($_POST['servico']) ? $_POST['servico'] : "Não informado";
$data = isset($_POST['data']) ? $_POST['data'] : "Não informado";
$hora = isset($_POST['hora']) ? $_POST['hora'] : "Não informado";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação do Agendamento</title>

    <!-- CSS GLOBAL (se existir) -->
    <link rel="stylesheet" href="style.css">

    <!-- CSS CORRETO DA CONFIRMAÇÃO -->
    <link rel="stylesheet" href="confirmacao.css">
</head>

<body>

<div class="container-confirmacao">

    <h1 class="title">Confirmação do Agendamento</h1>

    <div class="box-info">
        <p><strong>Serviço:</strong> <?php echo $servico; ?></p>
        <p><strong>Data:</strong> <?php echo $data; ?></p>
        <p><strong>Horário:</strong> <?php echo $hora; ?></p>
    </div>

    <div class="buttons">

        <form action="finalizar.php" method="POST">
            <input type="hidden" name="servico" value="<?php echo $servico; ?>">
            <input type="hidden" name="data" value="<?php echo $data; ?>">
            <input type="hidden" name="hora" value="<?php echo $hora; ?>">
            <button type="submit" class="btn confirmar">Confirmar</button>
        </form>

        <form action="desmarcar.php" method="POST">
            <input type="hidden" name="servico" value="<?php echo $servico; ?>">
            <input type="hidden" name="data" value="<?php echo $data; ?>">
            <input type="hidden" name="hora" value="<?php echo $hora; ?>">
            <button type="submit" class="btn desmarcar">Desmarcar</button>
        </form>

    </div>

</div>

</body>
</html>
