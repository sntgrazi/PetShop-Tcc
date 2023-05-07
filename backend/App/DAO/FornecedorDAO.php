<?php

namespace App\DAO;

use App\Model\FornecedorModel;

class FornecedorDAO extends ConexaoDAO {

    public function __construct() {
        parent::__construct();
    }

    public function getAllFornecedores(): array {
        $sql = 'SELECT * FROM fornecedores';
        $fornecedores = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        return $fornecedores;
    }

    public function getFornecedor(FornecedorModel $fornecedorM): array {
        $sql = 'SELECT * FROM fornecedores WHERE id = :id';
    
        $stm = $this->pdo->prepare($sql);
        $stm->execute(['id' => $fornecedorM->getId()]);
        $fornecedor = $stm->fetch(\PDO::FETCH_ASSOC);
        return $fornecedor;
    }

    public function insertFornecedor(FornecedorModel $fornecedor): void {
        $sql = 'INSERT INTO fornecedores VALUES (null, :nome_fantasia, :telefone, :email, :endereco, :cnpj)';

        $stm = $this->pdo
        ->prepare($sql);

        $stm->execute([
            'nome_fantasia' => $fornecedor->getNomeFantasia(),
            'telefone' => $fornecedor->getTelefone(),
            'email' => $fornecedor->getEmail(),
            'endereco' => $fornecedor->getEndereco(),
            'cnpj' => $fornecedor->getCnpj()
        ]);
    }

    public function updateFornecedor(FornecedorModel $fornecedor): void {
        $sql = 'UPDATE fornecedores SET nome_fantasia = :nome_fantasia, telefone = :telefone, email = :email, endereco = :endereco, cnpj = :cnpj WHERE id = :id';

        $stm = $this->pdo->prepare($sql);

        $stm->execute([
            'nome_fantasia' => $fornecedor->getNomeFantasia(),
            'telefone' => $fornecedor->getTelefone(),
            'email' => $fornecedor->getEmail(),
            'endereco' => $fornecedor->getEndereco(),
            'cnpj' => $fornecedor->getCnpj(),
            'id' => $fornecedor->getId()
        ]);
    }

    public function deleteFornecedor(FornecedorModel $fornecedor): void {
        $sql = 'DELETE FROM fornecedores WHERE id = :id';

        $stm = $this->pdo->prepare($sql);

        $stm->execute(['id' => $fornecedor->getId()]);
    }
}
