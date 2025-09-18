<?php

include_once __DIR__.'/../Database/Database.php';

class Categoria {
    
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function buscarCategorias(){
        $sql = 'SELECT *
        FROM tbl_categoria';
        $statment = $this->db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $statment -> execute();
        return $statment->fetchAll();
    }

    public function buscarCategoriasPorId($id){
        $sql = "SELECT * FROM tbl_categoria
        WHERE id_categoria =
        :id AND excluido_em IS NULL";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function inserirCategoria($nome, $descricao){
        $sql = "INSERT INTO tbl_categoria (
        nome_categoria,
        descricao_categoria
        )
        VALUES (
        :nome,
        :descricao
        )";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);

        if($stmt->execute()){
            return $this->db->lastInsertId();
        }
        else{
            return false;
        }
    }

    function atualizarCategoria($id, $nome, $descricao){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_categoria SET
        nome_categoria = :nome,
        descricao_categoria = :descricao,
        atualizado_em = :atual
        where id_categoria = :id";

        $stmt = $this->db->prepare($sql);
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nome', $nome);
        $stmt->bindParam(':descricao', $descricao);
        $stmt->bindParam(':atual', $dataAtual);

        if($stmt->execute()){
            return true;
        }
        else{
            return false;
        }
    }

    function excluirCategoria($id){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_categoria SET
        excluido_em = :atual
        where id_categoria = :id";

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