<?php
session_start();

// Confere se o serviço foi enviado
if (isset($_POST['servico']) && !empty($_POST['servico'])) {

    // Salva o serviço escolhido
    $_SESSION['servico_escolhido'] = $_POST['servico'];

    // Redireciona para página de agendamento
    header("Location: agendamento.html");
    exit();

} else {
    echo "<script>
        alert('Você precisa selecionar um serviço antes de continuar!');
        window.location.href = 'telaservicos.html';
    </script>";
    exit();
}
?>
