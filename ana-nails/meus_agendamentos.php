<?php
session_start();

// Verifica se o cliente está logado
if (!isset($_SESSION['cliente_id'])) {
    header("Location: login_cliente.php");
    exit();
}

$cliente_id = $_SESSION['cliente_id'];

// Conexão
$conn = new mysqli("localhost", "root", "", "ananails");
if ($conn->connect_error) {
    die("Erro na conexão: " . $conn->connect_error);
}

// Consulta agendamentos do cliente
$sql = "SELECT 
            A.id,
            A.data_agendamento,
            A.hora_agendamento,
            A.status,
            S.nome AS servico
        FROM agendamento A
        INNER JOIN servicos S ON A.servico_id = S.id
        WHERE A.cliente_id = $cliente_id
        ORDER BY A.data_agendamento, A.hora_agendamento";

$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<title>Meus Agendamentos</title>
<style>
body { font-family: Arial; background: #f8f8f8; }
.container { width: 90%; max-width: 650px; margin: 40px auto; background: #fff; padding: 25px; border-radius: 10px; }
h2 { text-align: center; color: #d63384; }
table { width: 100%; border-collapse: collapse; margin-top: 20px; }
th, td { padding: 12px; border-bottom: 1px solid #ddd; text-align: center; }
button.cancelar {
    padding: 6px 12px;
    background: #dc3545;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
button.cancelar:hover { background: #b52a37; }
.status-ativo { color: green; font-weight: bold; }
.status-cancelado { color: red; font-weight: bold; }
.status-outro { color: #333; font-weight: bold; }
</style>
</head>
<body>

<div class="container">
    <h2>Meus Agendamentos</h2>

    <table>
        <tr>
            <th>Serviço</th>
            <th>Data</th>
            <th>Hora</th>
            <th>Status</th>
            <th>Ação</th>
        </tr>

        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {

                $classe = "status-outro";
                if ($row['status'] === "ativo") $classe = "status-ativo";
                if ($row['status'] === "cancelado") $classe = "status-cancelado";

                echo "<tr>
                        <td>{$row['servico']}</td>
                        <td>{$row['data_agendamento']}</td>
                        <td>{$row['hora_agendamento']}</td>
                        <td class='$classe'>" . ucfirst($row['status']) . "</td>
                        <td>
                            <form method='POST' action='desmarcar.php'>
                                <input type='hidden' name='id' value='{$row['id']}'>
                                <button class='cancelar'>Desmarcar</button>
                            </form>
                        </td>
                    </tr>";
            }
        } else {
            echo "<tr><td colspan='5'>Nenhum agendamento encontrado.</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
