<?php

include_once __DIR__.'/../Database/Database.php';

class ItemAgendamento {
    
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function buscarItemAgendamentos(){
        $sql = 'SELECT *
        FROM tbl_item_agendamento';
        $statment = $this->db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $statment -> execute();
        return $statment->fetchAll();
    }

    public function buscarItemAgendamentosPorId($id){
        $sql = "SELECT * FROM tbl_item_agendamento
        WHERE id_item_agendamento =
        :id AND excluido_em IS NULL";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function inserirItemAgendamento($agendamento, $servico, $valor){
        $sql = "INSERT INTO tbl_item_agendamento (
        id_agendamento,
        id_servico,
        valor_servico
        )
        VALUES (
        :agendamento,
        :servico,
        :valor
        )";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':agendamento', $agendamento);
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

    function atualizarItemAgendamento($id, $agendamento, $servico, $valor){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_item_agendamento SET
        id_agendamento = :agendamento,
        id_servico = :servico,
        valor_servico = :valor,
        atualizado_em = :atual
        where id_item_agendamento = :id";

        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':agendamento', $agendamento);
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

    function excluirItemAgendamento($id){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_item_agendamento SET
        excluido_em = :atual
        where id_item_agendamento = :id";

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