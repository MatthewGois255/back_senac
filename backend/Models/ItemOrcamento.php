<?php

include_once __DIR__.'/../Database/Database.php';

class ItemOrcamento {
    
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function buscarItemOrcamentos(){
        $sql = 'SELECT *
        FROM tbl_item_orcamento';
        $statment = $this->db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $statment -> execute();
        return $statment->fetchAll();
    }

    public function buscarItemOrcamentosPorId($id){
        $sql = "SELECT * FROM tbl_item_orcamento
        WHERE id_item_orcamento =
        :id AND excluido_em IS NULL";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function inserirItemOrcamento($orcamento, $servico, $valor){
        $sql = "INSERT INTO tbl_item_orcamento (
        id_orcamento,
        id_servico,
        valor_servico
        )
        VALUES (
        :orcamento,
        :servico,
        :valor
        )";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':orcamento', $orcamento);
        $stmt->bindParam(':servico', $servico);
        $stmt->bindParam(':valor', $valor);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }
        else{
            return false;
        }
    }

    // parei aqui

    function atualizarItemOrcamento($id, $orcamento, $servico, $valor){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_item_orcamento SET
        id_orcamento = :orcamento,
        id_servico = :servico,
        valor_servico = :valor,
        atualizado_em = :atual
        where id_item_orcamento = :id";

        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':orcamento', $orcamento);
        $stmt->bindParam(':servico', $servico);
        $stmt->bindParam(':valor', $valor);
        $stmt->bindParam(':atual', $dataAtual);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    function excluirItemOrcamento($id){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_item_orcamento SET
        excluido_em = :atual
        where id_item_orcamento = :id";

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