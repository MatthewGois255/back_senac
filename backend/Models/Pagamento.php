<?php

include_once __DIR__.'/../Database/Database.php';

class Pagamento {
    
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function buscarPagamentos(){
        $sql = 'SELECT *
        FROM tbl_pagamento';
        $statment = $this->db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $statment -> execute();
        return $statment->fetchAll();
    }

    public function buscarPagamentosPorId($id){
        $sql = "SELECT * FROM tbl_pagamento
        WHERE id_pagamento =
        :id AND excluido_em IS NULL";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function inserirPagamento($cliente, $total_devedor, $status){
        $sql = "INSERT INTO tbl_pagamento (
        id_cliente,
        total_devedor,
        status_pagamento
        )
        VALUES (
        :cliente,
        :total_devedor,
        :status        
        )";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':cliente', $cliente);
        $stmt->bindParam(':total_devedor', $total_devedor);
        $stmt->bindParam(':status', $status);
        if($stmt->execute()){
            return $this->db->lastInsertId();
        }
        else{
            return false;
        }
    }

    function atualizarPagamento($id, $cliente, $total_devedor, $status){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_pagamento SET
        id_cliente = :cliente,
        total_devedor = :total_devedor,
        status_pagamento = :status,
        atualizado_em = :atual
        where id_pagamento = :id";

        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':cliente', $cliente);
        $stmt->bindParam(':total_devedor', $total_devedor);
        $stmt->bindParam(':status', $status);
        $stmt->bindParam(':atual', $dataAtual);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    function excluirPagamento($id){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_pagamento SET
        excluido_em = :atual
        where id_pagamento = :id";

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