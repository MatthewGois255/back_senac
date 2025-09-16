<?php

include_once __DIR__.'/../Database/Database.php';

class Contato {
    
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function buscarContatos(){
        $sql = 'SELECT *
        FROM tbl_contato';
        $statment = $this->db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $statment -> execute();
        return $statment->fetchAll();
    }

    public function buscarContatosPorEmail($email){
        $sql = "SELECT * FROM tbl_contato
        WHERE email_contato =
        :email AND excluido_em IS NULL";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function inserirContato($nome, $telefone, $email){
        $sql = "INSERT INTO tbl_contato (
        nome_contato,
        telefone_contato,
        email_contato
        )
        VALUES (
        :nome,
        :email,
        :telefone
        )";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);

        if($stmt->execute()){
            return $this->db->lastInsertId();
        }
        else{
            return false;
        }
    }

    function atualizarContato($id, $nome, $telefone, $email){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_contato SET
        nome_contato = :nome,
        telefone_contato = :telefone,
        email_contato = :email,
        atualizado_em = :atual
        where id_contato = :id";

        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':telefone', $telefone);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':atual', $dataAtual);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    function excluirContato($id){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_contato SET
        excluido_em = :atual
        where id_contato = :id";

        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':atual', $dataAtual);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }
}



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