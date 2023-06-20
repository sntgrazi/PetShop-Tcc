<?php

namespace App\DAO;
use App\Model\FuncionarioModel;

class FuncionariosDAO extends ConexaoDAO{
    public function __construct(){
        parent::__construct();
    }

    public function getAllFuncionarios(): array{
        $sql = 'SELECT f.*, c.nome_cargo
        FROM funcionarios f 
        JOIN cargos c ON f.cargo_id = c.id ORDER BY id';
        $funcionarios = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        return $funcionarios;
    }

    public function getAllCargos(): array{
        $sql = 'SELECT * FROM cargos';
        $cargos = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        return $cargos;
    }

    public function getFuncionarioById(FuncionarioModel $funcionarioM): array{
        $sql = 'SELECT * FROM funcionarios WHERE id = :id';

        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'id' =>$funcionarioM->getId()
        ]);

        $funcionario = $stm->fetch(\PDO::FETCH_ASSOC);
        return $funcionario;
    }

    public function cadastrarFuncionario(FuncionarioModel $funcionarioM): void{
        $sql = 'INSERT INTO funcionarios VALUES (null, :nome, :telefone, :cpf, :endereco, :cargo_id)';

        $stm = $this->pdo
        ->prepare($sql);

        $stm->execute([
            'nome' => $funcionarioM->getNome(),
            'telefone' => $funcionarioM->getTelefone(),
            'cpf' => $funcionarioM->getCpf(),
            'endereco' => $funcionarioM->getEndereco(),
            'cargo_id' => $funcionarioM->getCargo()
        ]);

    }

    public function editarFuncionario(FuncionarioModel $funcionarioM): void{
        $sql = 'UPDATE funcionarios SET nome = :nome, telefone = :telefone, cpf = :cpf, endereco = :endereco, cargo_id = :cargo_id WHERE id = :id';

        $stm = $this->pdo->prepare($sql);

        $stm->execute([
            'nome' => $funcionarioM->getNome(),
            'telefone' => $funcionarioM->getTelefone(),
            'cpf' => $funcionarioM->getCpf(),
            'endereco' => $funcionarioM->getEndereco(),
            'cargo_id' => $funcionarioM->getCargo(),
            'id' => $funcionarioM->getId()
        ]);
    }

    public function deleteFuncionario(FuncionarioModel $funcionarioM): void{

        $sql = 'DELETE FROM funcionarios WHERE id = :id';

        $stm = $this->pdo->prepare($sql);

        $stm->execute(['id' => $funcionarioM->getId()]);

    }
}