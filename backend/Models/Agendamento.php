<?php

include_once __DIR__.'/../Database/Database.php';

class Agendamento {
    
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function buscarAgendamentos(){
        $sql = 'SELECT *
        FROM tbl_agendamento';
        $statment = $this->db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $statment -> execute();
        return $statment->fetchAll();
    }

    public function buscarAgendamentosPorId($id){
        $sql = "SELECT * FROM tbl_agendamento
        WHERE id_cliente =
        :id AND excluido_em IS NULL";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function inserirAgendamento($id, $data, $status){
        $sql = "INSERT INTO tbl_agendamento (
        id_cliente,
        data_solicitada,
        status_agendamento
        )
        VALUES (
        :id,
        :data,
        :status
        )";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':status', $status);

        if($stmt->execute()){
            return $this->db->lastInsertId();
        }
        else{
            return false;
        }
    }

    function atualizarAgendamento($id, $id_cliente, $data, $status){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_agendamento SET
        id_cliente = :id_cliente,
        data_solicitada = :data,
        status_agendamento = :status,
        atualizado_em = :atual
        where id_agendamento = :id";

        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_cliente', $id_cliente);
        $stmt->bindParam(':data', $data);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atual', $dataAtual);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    function excluirAgendamento($id){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_agendamento SET
        excluido_em = :atual
        where id_agendamento = :id";

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