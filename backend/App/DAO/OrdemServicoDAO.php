<?php

namespace App\DAO;

use App\Model\OrdemServicoModel;

class OrdemServicDAO extends ConexaoDAO{
    public function __construct(){
        parent::__construct();
    }

    public function getAllOrdens(): array{
        $sql = 'SELECT * from ordem_de_servico';
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