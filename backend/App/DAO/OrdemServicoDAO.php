<?php

namespace App\DAO;

use App\Model\OrdemServicoModel;

class OrdemServicoDAO extends ConexaoDAO{
    public function __construct(){
        parent::__construct();
    }

    public function getAllOrdens(): array{
        $sql = 'SELECT ordem_de_servico.id, clientes.nome AS nome_cliente, animais.nome_pet AS nome_animal, funcionarios.nome AS nome_funcionario, servicos.nome_servico AS nome_servico , ordem_de_servico.status
        FROM ordem_de_servico 
        JOIN clientes ON ordem_de_servico.cliente_id = clientes.id 
        JOIN animais ON ordem_de_servico.animal_id = animais.id 
        JOIN funcionarios ON ordem_de_servico.funcionario_id = funcionarios.id 
        JOIN servicos ON ordem_de_servico.servico_id = servicos.id;';
        $ordens = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        return $ordens;
    }

    public function insertOrdem(OrdemServicoModel $ordemM ){
        $sql = 'INSERT INTO ordem_de_servico (data_ordem, cliente_id, animal_id, funcionario_id, servico_id,
         hora_inicio, hora_termino, duracao) values (:data_ordem , :cliente_id, :animal_id, :funcionario_id, :servico_id,
         :hora_inicio, :hora_termino, :duracao)';

        $stm = $this->pdo
        ->prepare($sql);

        $stm->execute([
            'data_ordem' => $ordemM->getData(),
            'cliente_id' => $ordemM->getCliente_id(),
            'animal_id' => $ordemM->getAnimal_id(),
            'funcionario_id' => $ordemM->getFuncionario_id(),
            'servico_id' => $ordemM->getServico_id(),
            'hora_inicio' => $ordemM->getHora_inicio(),
            'hora_termino' => $ordemM->getHora_termino(),
            'duracao' => $ordemM->getDuracao()
        ]);
    }
}