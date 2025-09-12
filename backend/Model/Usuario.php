<?php

function buscarUsuarios($db){
    $sql = 'SELECT nome_usuario, email_usuario
    FROM tbl_usuario
    WHERE id_usuario = :id';
    $statment = $db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $statment -> execute(['id' => 5 ]);
    return $resultado = $statment->fetchAll();
}

function buscarUsuarioPorId($db, $id){
    $sql = 'SELECT id_usuario, nome_usuario, email_usuario
    FROM tbl_usuario
    WHERE id_usuario = :id';
    $statment = $db->prepare($sql);
    $statment -> bindParam(':id', $id);
    return $resultado = $statment -> execute();
}

function registrarUsuario($db, $nome, $email, $senha){
    $sql = 'INSERT INTO tbl_usuario (nome_usuario, email_usuario, senha_usuario)
    VALUES (:nome, :email, :senha)';
    $statment = $db->prepare($sql);
    $statment -> bindParam(':nome', $nome);
    $statment -> bindParam(':senha', $senha);
    $statment -> bindParam(':email', $email);
    return $statment -> execute();
}