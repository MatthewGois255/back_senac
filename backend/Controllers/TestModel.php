<?php
require_once 'C:/xampp/htdocs/kipedreiro/backend/Models/Endereco.php';
require_once __DIR__.'/../Database/Database.php';

$usuario = new Endereco($db);

$resultado = $usuario->buscarEnderecos();
// $resultado = $usuario->buscarEnderecosPorId(6);
// $resultado = $usuario->inserirEndereco('DryWall', 'Montagem e desmontagem de DryWalls');
// $resultado = $usuario->atualizarEndereco(21, 'DryWall', 'Agora só fazemos montagens');
// $resultado = $usuario->excluirEndereco(21);

var_dump($resultado);