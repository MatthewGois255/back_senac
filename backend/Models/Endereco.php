<?php

include_once __DIR__.'/../Database/Database.php';

class Endereco {
    
    private $db;

    public function __construct($db){
        $this->db = $db;
    }

    public function buscarEnderecos(){
        $sql = 'SELECT *
        FROM tbl_endereco';
        $statment = $this->db->prepare($sql, [PDO::ATTR_CURSOR => PDO::CURSOR_FWDONLY]);
        $statment -> execute();
        return $statment->fetchAll();
    }

    public function buscarEnderecosPorId($id){
        $sql = "SELECT * FROM tbl_endereco
        WHERE id_endereco =
        :id AND excluido_em IS NULL";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    
    function inserirEndereco($logradouro, $numero, $cidade, $usuario){
        $sql = "INSERT INTO tbl_endereco (
        logradouro_endereco,
        numero_endereco,
        cidade_endereco,
        id_usuario
        )
        VALUES (
        :logradouro,
        :numero,
        :cidade,
        :usuario
        )";

        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':logradouro', $logradouro);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':cidade', $cidade);
        $stmt->bindParam(':usuario', $usuario);

        if($stmt->execute()){
            return $this->db->lastInsertId();
        }
        else{
            return false;
        }
    }

    // parei aqui

    function atualizarEndereco($id, $nome, $descricao){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_endereco SET
        nome_endereco = :nome,
        descricao_endereco = :descricao,
        atualizado_em = :atual
        where id_endereco = :id";

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

    function excluirEndereco($id){
        $dataAtual = date('Y-m-d H:i:s');

        $sql = "UPDATE tbl_endereco SET
        excluido_em = :atual
        where id_endereco = :id";

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