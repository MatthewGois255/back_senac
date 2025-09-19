<?php
require_once 'C:/xampp/htdocs/kipedreiro/backend/Models/Endereco.php';
require_once 'C:/xampp/htdocs/kipedreiro/backend/Models/Usuario.php';
require_once __DIR__.'/../Database/Database.php';

$usuario = new Usuario($db);
$endereco = new Endereco($db);

$id = $usuario->inserirUsuario(
    'Matheus',
    'emaildomatheus@gmail.com',
    '9876',
    'Cliente',
    'Ativo'
);

$address = $endereco->inserirEndereco(
    'Aquela rua lá',
    0,
    'Campinas',
    $id
);

if($address) {
    echo "Deu bom fiote";
}
else {
    echo 'vish, moiô paizão';
}

var_dump($usuario->buscarUsuariosInativos());