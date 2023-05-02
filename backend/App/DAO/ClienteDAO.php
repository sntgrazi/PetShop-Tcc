<?php

namespace App\DAO;

use App\Model\ClienteModel;

class ClienteDAO extends ConexaoDAO{

    public function __construct(){
        parent::__construct();
    }

    public function getAllClientes(): array{
        $sql = 'SELECT * from clientes';
        $clientes = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        return $clientes;
    }

    
    public function getCliente(ClienteModel $clienteM): array{
        $sql = 'SELECT * from clientes WHERE id = :id';
    
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'id' => $clienteM->getId()
        ]);
        $cliente = $stm->fetch(\PDO::FETCH_ASSOC);
        return $cliente;
    }

    public function insertCliente(ClienteModel $cliente): void {
        $sql = 'INSERT INTO clientes VALUES (null, :nome, :telefone, :cpf, :rg, :email, :endereco)';

        $stm = $this->pdo
        ->prepare($sql);

        $stm->execute([
            'nome' => $cliente->getNome(),
            'telefone' => $cliente->getTelefone(),
            'cpf' => $cliente->getCpf(),
            'rg' => $cliente->getRg(),
            'email' => $cliente->getEmail(),
            'endereco' => $endereco = $cliente->getCep() . ',' . $cliente->getBairro() . ',' . $cliente->getRua() . ',' . $cliente->getCidade() . ',' . $cliente->getUf() . ',' . $cliente->getN_casa()
        ]);
    }

    public function updateCliente(ClienteModel $cliente): void {
        $sql = 'UPDATE clientes SET nome = :nome, telefone = :telefone, cpf = :cpf , rg = :rg, email = :email, endereco = :endereco WHERE id = :id';

        $stm = $this->pdo->prepare($sql);

        $stm->execute([
            'nome' => $cliente->getNome(),
            'telefone' => $cliente->getTelefone(),
            'cpf' => $cliente->getCpf(),
            'rg' => $cliente->getRg(),
            'email' => $cliente->getEmail(),
            'endereco' => $endereco = $cliente->getCep() . ',' . $cliente->getBairro() . ',' . $cliente->getRua() . ',' . $cliente->getCidade() . ',' . $cliente->getUf() . ',' . $cliente->getN_casa(),
            'id' => $cliente->getId()
        ]);
    }

    public function deleteCliente(ClienteModel $cliente): void{
        $sql = 'DELETE FROM clientes WHERE id = :id';

        $stm = $this->pdo->prepare($sql);

        $stm->execute(['id' => $cliente->getId()]);
    }
}