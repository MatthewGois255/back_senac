<?php

include_once __DIR__.'/../Database/Database.php';

class Avaliacao {
    
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function buscarAvaliacoes(){
        $sql = 'SELECT *
        FROM tbl_avaliacao';
        $statment = $this->db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $statment -> execute();
        return $statment->fetchAll();
    }

    public function buscarAvaliacoesPorId($id){
        $sql = "SELECT * FROM tbl_avaliacao
        WHERE id_avaliacao =
        :id AND excluido_em IS NULL";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function inserirAvaliacao($cliente, $avaliacao, $nota){
        $sql = "INSERT INTO tbl_avaliacao (
        id_cliente,
        descricao_avaliacao,
        nota_avaliacao
        )
        VALUES (
        :cliente,
        :avaliacao,
        :nota
        )";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cliente', $cliente);
        $stmt->bindParam(':avaliacao', $avaliacao);
        $stmt->bindParam(':nota', $nota);

        if($stmt->execute()){
            return $this->db->lastInsertId();
        }
        else{
            return false;
        }
    }

    function atualizarAvaliacao($id, $cliente, $avaliacao, $nota){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_avaliacao SET
        id_cliente = :cliente,
        descricao_avaliacao = :avaliacao,
        nota_avaliacao = :nota,
        atualizado_em = :atual
        where id_avaliacao = :id";

        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':cliente', $cliente);
        $stmt->bindParam(':avaliacao', $avaliacao);
        $stmt->bindParam(':nota', $nota);
        $stmt->bindParam(':atual', $dataAtual);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    function excluirAvaliacao($id){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_avaliacao SET
        excluido_em = :atual
        where id_avaliacao = :id";

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