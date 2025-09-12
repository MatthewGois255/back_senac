<?php

function buscarContato($db){
    $sql = 'SELECT nome_contato, email_contato
    FROM tbl_contato
    WHERE id_contato = :id';
    $statment = $db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
    $statment -> execute(['id' => 5 ]);
    return $resultado = $statment->fetchAll();
}

function buscarContatoPorId($db, $id){
    $sql = 'SELECT id_contato, nome_contato, email_contato
    FROM tbl_contato
    WHERE id_contato = :id';
    $statment = $db->prepare($sql);
    $statment -> bindParam(':id', $id);
    return $resultado = $statment -> execute();
}

function registrarContato($db, $nome, $telefone, $email){
    $sql = 'INSERT INTO tbl_contato (nome_contato, email_contato, telefone_contato)
    VALUES (:nome, :email, :telefone)';
    $statment = $db->prepare($sql);
    $statment -> bindParam(':nome', $nome);
    $statment -> bindParam(':telefone', $telefone);
    $statment -> bindParam(':email', $email);
    return $statment -> execute();
}