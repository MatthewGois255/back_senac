<?php
include_once 'backend/Database/Database.php';
include_once 'backend/Usuario.php';

$nome = $POST['nome'] ?? '';
$email = $POST['email'] ?? '';
$senha = $POST['senha'] ?? '';

$ok = registrarUsuario($db, $nome, $email, $senha);
if($ok) {
    echo "Usuário cadastrado com sucesso";
}
else {
    echo "Erro ao cadastrar";
}