<?php
session_start();
if(!isset($_SESSION['admin_id'])){
    header("Location: login_adm.php");
    exit();
}

$conn = new mysqli("localhost","root","","ananails");
if ($conn->connect_error) die("Erro de conexão: " . $conn->connect_error);

// Atualizar status
if(isset($_POST['acao']) && isset($_POST['id'])){
    $acao = $_POST['acao'];
    $id = intval($_POST['id']);

    if($acao === 'confirmar' || $acao === 'cancelar'){
        $novoStatus = ($acao === 'confirmar') ? 'Confirmado' : 'Cancelado';

        $stmt = $conn->prepare("UPDATE agendamento SET status=? WHERE id=?");
        $stmt->bind_param("si", $novoStatus, $id);
        $stmt->execute();
    }

    header("Location: agenda_adm.php");
    exit();
}

// Filtro e pesquisa
$statusFiltro = $_GET['status'] ?? 'Todos';
$pesquisa = $_GET['pesquisa'] ?? '';

$where = [];
if($statusFiltro !== 'Todos'){
    $where[] = "A.status='$statusFiltro'";
}
if(!empty($pesquisa)){
    $pesquisa = $conn->real_escape_string($pesquisa);
    $where[] = "(C.nome LIKE '%$pesquisa%' OR S.nome LIKE '%$pesquisa%')";
}

$whereSQL = (count($where) > 0) ? "WHERE ".implode(" AND ", $where) : "";


$sql = "SELECT 
            A.id,
            C.nome AS cliente,
            S.nome AS servico,
            A.data_agendamento,
            A.hora_agendamento,
            A.status
        FROM agendamento A
        INNER JOIN clientes C ON A.cliente_id = C.id
        INNER JOIN servicos S ON A.servico_id = S.id
        $whereSQL
        ORDER BY A.data_agendamento, A.hora_agendamento";

$result = $conn->query($sql);
if(!$result){
    die("Erro na consulta: " . $conn->error);
}
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Agenda Administrador</title>
<link rel="stylesheet" href="styleadm.css">

<style>
.agenda-container { max-width: 1100px; margin: 50px auto; padding: 20px; background: #fff; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.1); font-family: Arial, sans-serif; }
.agenda-container h2 { margin-bottom: 20px; color: #333; }
.logout { float: right; text-decoration: none; color: #fff; background: #dc3545; padding: 6px 12px; border-radius: 6px; transition: 0.3s; }
.logout:hover { background: #c82333; }

form#filtroForm { margin-bottom: 20px; display: flex; flex-wrap: wrap; gap: 10px; align-items: center; }
form#filtroForm select, form#filtroForm input { padding: 6px 10px; border-radius: 6px; border: 1px solid #ccc; font-size: 14px; }
form#filtroForm button { padding: 6px 12px; border: none; border-radius: 6px; background-color: #007bff; color: #fff; cursor: pointer; font-size: 14px; transition: 0.3s; }
form#filtroForm button:hover { background-color: #0069d9; }

table { width: 100%; border-collapse: collapse; margin-top: 10px; }
th, td { padding: 12px 15px; text-align: center; }
th { background-color: #007bff; color: #fff; text-transform: uppercase; font-weight: 500; }
tr { border-bottom: 1px solid #ddd; transition: 0.3s; }
tr:hover { background-color: #f1f1f1; }

.status-confirmado { background-color: #d4edda; }
.status-cancelado  { background-color: #f8d7da; }
.status-pendente   { background-color: #fff3cd; }

.btn-acao { padding: 6px 12px; margin: 0 2px; border: none; border-radius: 6px; cursor: pointer; font-size: 14px; color: #fff; text-decoration: none; display: inline-block; transition: 0.3s; }
.btn-confirmar { background-color: #28a745; }
.btn-confirmar:hover { background-color: #218838; }
.btn-cancelar { background-color: #dc3545; }
.btn-cancelar:hover { background-color: #c82333; }
.btn-disabled { background-color: #6c757d; cursor: not-allowed; }

@media(max-width: 768px){
    th, td { font-size: 12px; padding: 8px; }
    .btn-acao { font-size: 12px; padding: 4px 8px; }
    .logout { padding: 4px 8px; font-size: 12px; }
    form#filtroForm { flex-direction: column; align-items: flex-start; }
}
</style>

</head>
<body>

<div class="agenda-container">
    <h2>Agenda do Administrador - <?php echo htmlspecialchars($_SESSION['admin_nome']); ?></h2>
    <a href="logout.php" class="logout">Sair</a>

    <form id="filtroForm" method="GET">
        <label>Status:
            <select name="status">
                <option value="Todos" <?php if($statusFiltro=='Todos') echo 'selected'; ?>>Todos</option>
                <option value="Pendente" <?php if($statusFiltro=='Pendente') echo 'selected'; ?>>Pendente</option>
                <option value="Confirmado" <?php if($statusFiltro=='Confirmado') echo 'selected'; ?>>Confirmado</option>
                <option value="Cancelado" <?php if($statusFiltro=='Cancelado') echo 'selected'; ?>>Cancelado</option>
            </select>
        </label>
        <label>Pesquisar:
            <input type="text" name="pesquisa" placeholder="Cliente ou Serviço" value="<?php echo htmlspecialchars($pesquisa); ?>">
        </label>
        <button type="submit">Filtrar</button>
    </form>

    <table>
        <tr>
            <th>Cliente</th>
            <th>Serviço</th>
            <th>Data</th>
            <th>Hora</th>
            <th>Status</th>
            <th>Ações</th>
        </tr>

        <?php
        if($result->num_rows > 0){
            while($row = $result->fetch_assoc()){

                $classeStatus = '';
                if($row['status'] === 'Confirmado') $classeStatus = 'status-confirmado';
                elseif($row['status'] === 'Cancelado') $classeStatus = 'status-cancelado';
                else $classeStatus = 'status-pendente';

                echo "<tr class='{$classeStatus}'>
                        <td>".htmlspecialchars($row['cliente'])."</td>
                        <td>".htmlspecialchars($row['servico'])."</td>
                        <td>".htmlspecialchars($row['data_agendamento'])."</td>
                        <td>".htmlspecialchars($row['hora_agendamento'])."</td>
                        <td>".htmlspecialchars($row['status'])."</td>
                        <td>";

                echo "<form style='display:inline;' method='POST'>";
                echo "<input type='hidden' name='id' value='".intval($row['id'])."'>";

                if($row['status'] !== 'Confirmado'){
                    echo "<button class='btn-acao btn-confirmar' type='submit' name='acao' value='confirmar'>Confirmar</button>";
                } else {
                    echo "<button class='btn-acao btn-disabled' disabled>Confirmado</button>";
                }

                if($row['status'] !== 'Cancelado'){
                    echo "<button class='btn-acao btn-cancelar' type='submit' name='acao' value='cancelar'>Cancelar</button>";
                } else {
                    echo "<button class='btn-acao btn-disabled' disabled>Cancelado</button>";
                }

                echo "</form></td></tr>";
            }
        } else {
            echo "<tr><td colspan='6' style='text-align:center;'>Nenhum agendamento encontrado.</td></tr>";
        }
        ?>
    </table>
</div>

</body>
</html>
