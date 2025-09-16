<?php

include_once __DIR__.'/../Database/Database.php';

class Usuario {
    
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function buscarUsuarios(){
        $sql = 'SELECT *
        FROM tbl_usuario';
        $statment = $this->db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $statment -> execute();
        return $statment->fetchAll();
    }

    public function buscarUsuariosPorEmail($email){
        $sql = "select * from tbl_usuario where email_usuario = :email and excluido_em is null";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function inserirUsuario($nome, $email, $senha, $tipo, $status){
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $sql = "INSERT INTO tbl_usuario (nome_usuario, email_usuario, senha_usuario, tipo_usuario, status_usuario)
        values (:nome, :email, :senha, :tipo, :status)";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':status', $status);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }
        else{
            return false;
        }
    }

    function atualizarUsuario($id, $nome, $email, $senha, $tipo, $status){
        $senha = password_hash($senha, PASSWORD_DEFAULT);
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_usuario SET nome_usuario = :nome,
        email_usuario = :email,
        senha_usuario = :senha,
        tipo_usuario = :tipo,
        status_usuario = :status,
        atualizado_em = :atual
        where id_usuario = :id";

        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':senha', $senha);
        $stmt->bindParam(':tipo', $tipo);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atual', $dataAtual);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    function excluirUsuario($id){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_usuario SET
        excluido_em = :atual
        where id_usuario = :id";

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