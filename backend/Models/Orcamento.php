<?php

include_once __DIR__.'/../Database/Database.php';

class Orcamento {
    
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function buscarOrcamentos(){
        $sql = 'SELECT *
        FROM tbl_orcamento';
        $statment = $this->db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $statment -> execute();
        return $statment->fetchAll();
    }

    public function buscarOrcamentosPorId($id){
        $sql = "SELECT * FROM tbl_orcamento
        WHERE id_orcamento =
        :id AND excluido_em IS NULL";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function inserirOrcamento($cliente, $categoria, $profissional){
        $sql = "INSERT INTO tbl_orcamento (
        id_cliente,
        id_categoria,
        id_profissional
        )
        VALUES (
        :cliente,
        :categoria,
        :profissional        
        )";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cliente', $cliente);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':profissional', $profissional);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }
        else{
            return false;
        }
    }

    function atualizarOrcamento($id, $cliente, $categoria, $profissional){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_orcamento SET
        id_cliente = :cliente,
        id_categoria = :categoria,
        id_profissional = :profissional,
        atualizado_em = :atual
        where id_orcamento = :id";

        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':cliente', $cliente);
        $stmt->bindParam(':categoria', $categoria);
        $stmt->bindParam(':profissional', $profissional);
        $stmt->bindParam(':atual', $dataAtual);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    function excluirOrcamento($id){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_orcamento SET
        excluido_em = :atual
        where id_orcamento = :id";

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