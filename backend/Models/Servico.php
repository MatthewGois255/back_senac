<?php

include_once __DIR__.'/../Database/Database.php';

class Servico {
    
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function buscarServicos(){
        $sql = 'SELECT *
        FROM tbl_servico';
        $statment = $this->db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $statment -> execute();
        return $statment->fetchAll();
    }

    public function buscarServicosPorId($id){
        $sql = "SELECT * FROM tbl_servico
        WHERE id_servico =
        :id AND excluido_em IS NULL";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function inserirServico($nome, $valor, $status){
        $sql = "INSERT INTO tbl_servico (
        nome_servico,
        valor_base_servico,
        status_servico
        )
        VALUES (
        :nome,
        :valor,
        :status
        )";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':status', $status);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }
        else{
            return false;
        }
    }

    function atualizarServico($id, $nome, $valor, $status){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_servico SET
        nome_servico = :nome,
        valor_base_servico = :valor,,
        status_servico = :status,
        atualizado_em = :atual
        where id_servico = :id";

        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atual', $dataAtual);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    function excluirServico($id){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_servico SET
        excluido_em = :atual
        where id_servico = :id";

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