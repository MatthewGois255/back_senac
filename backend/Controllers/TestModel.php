<?php
require_once 'C:/xampp/htdocs/kipedreiro/backend/Models/Contato.php';
require_once __DIR__.'/../Database/Database.php';

$usuario = new Contato($db);

// $resultado = $usuario->buscarContatos();
// $resultado = $usuario->buscarContatosPorEmail("juliana.a@emailaleatorio.com");
// $resultado = $usuario->inserirContato("Jão", "12345", "emaildojao@gmail.com");
// $resultado = $usuario->atualizarContato(27, "Jão", "54321", "emaildojao@gmail.com");
// $resultado = $usuario->excluirContato(27);
var_dump($resultado);