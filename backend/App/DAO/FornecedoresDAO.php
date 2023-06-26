<?php

namespace App\DAO;

use App\Model\FornecedoresModel;

class FornecedoresDAO extends ConexaoDAO
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getAllFornecedores(): array
    {
        $sql = 'SELECT * FROM fornecedores ORDER BY id';
        $fornecedores = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        return $fornecedores;
    }

    public function getFornecedorById(FornecedoresModel $fornecedor): ?array
    {
        $sql = 'SELECT * FROM fornecedores WHERE id = :id';
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute([
            'id' => $fornecedor->getId()
        ]);

        $fornecedor = $stmt->fetch(\PDO::FETCH_ASSOC);

        return $fornecedor ?: null;
    }


    public function cadastrarFornecedor(FornecedoresModel $fornecedor): void
    {
        $sql = 'INSERT INTO fornecedores (nome_fantasia, telefone, email, cnpj) VALUES (:nome_fantasia, :telefone, :email, :cnpj)';

        $stm = $this->pdo->prepare($sql);

        $stm->execute([
            'nome_fantasia' => $fornecedor->getNomeFantasia(),
            'telefone' => $fornecedor->getTelefone(),
            'email' => $fornecedor->getEmail(),
            'cnpj' => $fornecedor->getCnpj()
        ]);
    }

    public function atualizarFornecedor(FornecedoresModel $fornecedor): void
    {
        $sql = 'UPDATE fornecedores SET nome_fantasia = :nome_fantasia, telefone = :telefone, email = :email, cnpj = :cnpj WHERE id = :id';

        $stm = $this->pdo->prepare($sql);

        $stm->execute([
            'id' => $fornecedor->getId(),
            'nome_fantasia' => $fornecedor->getNomeFantasia(),
            'telefone' => $fornecedor->getTelefone(),
            'email' => $fornecedor->getEmail(),
            'cnpj' => $fornecedor->getCnpj()
        ]);
    }

    public function deletarFornecedor(FornecedoresModel $fornecedor): void
    {
        $sql = 'DELETE FROM fornecedores WHERE id = :id';

        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'id' => $fornecedor->getId()
        ]);
    }
}
