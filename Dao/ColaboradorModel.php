<?php

namespace App\DAO;

use App\Model\ColaboradorModel;

class ColaboradorDAO extends ConexaoDAO {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function getAllColaboradores(): array {
        $sql = 'SELECT * FROM colaboradores';
        $colaboradores = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);
        
        return $colaboradores;
    }
    
    public function getColaborador(ColaboradorModel $colaboradorM): array {
        $sql = 'SELECT * FROM colaboradores WHERE id = :id';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute(['id' => $colaboradorM->getId()]);
        
        $colaborador = $stm->fetch(\PDO::FETCH_ASSOC);
        
        return $colaborador;
    }
    
    public function insertColaborador(ColaboradorModel $colaborador): void {
        $sql = 'INSERT INTO colaboradores VALUES (null, :nome, :telefone, :cpf, :endereco, :email, :cargo)';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'nome' => $colaborador->getNome(),
            'telefone' => $colaborador->getTelefone(),
            'cpf' => $colaborador->getCpf(),
            'endereco' => $colaborador->getEndereco(),
            'email' => $colaborador->getEmail(),
            'cargo' => $colaborador->getCargo()
        ]);
    }
    
    public function updateColaborador(ColaboradorModel $colaborador): void {
        $sql = 'UPDATE colaboradores SET nome = :nome, telefone = :telefone, cpf = :cpf, endereco = :endereco, email = :email, cargo = :cargo WHERE id = :id';
        
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'id' => $colaborador->getId(),
            'nome' => $colaborador->getNome(),
            'telefone' => $colaborador->getTelefone(),
            'cpf' => $colaborador->getCpf(),
            'endereco' => $colaborador->getEndereco(),
            'email' => $colaborador->getEmail(),
            'cargo' => $colaborador->getCargo()
        ]);
    }
    
    public function deleteColaborador(ColaboradorModel $colaborador): void {
        $sql = 'DELETE FROM colaboradores WHERE id = :id';
        
        $stm = $this->pdo->prepare($sql);
        
        $stm->execute(['id' => $colaborador->getId()]);
    }
    
}
