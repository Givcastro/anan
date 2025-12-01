<?php
$conn = new mysqli("localhost","root","","ananails");
if ($conn->connect_error) die("Erro: " . $conn->connect_error);

// COLOQUE AQUI O EMAIL DO ADMIN QUE VOCÊ CADASTROU
$email = "EMAIL_DO_ADMIN_AQUI";

// COLOQUE AQUI A SENHA NOVA QUE VOCÊ QUER USAR
$novaSenha = "123456";

$hash = password_hash($novaSenha, PASSWORD_DEFAULT);

$sql = $conn->prepare("UPDATE ADMIN SET senha = ? WHERE email = ?");
$sql->bind_param("ss", $hash, $email);

if($sql->execute()){
    echo "Senha atualizada com sucesso! Agora sua senha é: " . $novaSenha;
} else {
    echo "Erro: " . $sql->error;
}
?>
