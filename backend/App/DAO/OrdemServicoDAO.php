<?php

namespace App\DAO;

use App\Model\OrdemServicoModel;

class OrdemServicoDAO extends ConexaoDAO{
    public function __construct(){
        parent::__construct();
    }

    public function getOrdensById(): array{
        $sql = 'SELECT 
        ord.data_inicio, 
        ord.data_termino, 
        ord.hora_inicio, 
        ord.hora_termino, 
        ord.duracao, 
        ord.status,
        an.nome_pet AS nome_animal,
        f.nome AS nome_funcionario,
        c.nome AS nome_cliente, 
        s.nome_servico AS nome_servico
        FROM 
            ordem_de_servico ord
        JOIN 
            animais an ON ord.animal_id = an.id
        JOIN 
            funcionarios f ON ord.funcionario_id = f.id
        JOIN 
            clientes c ON ord.cliente_id = c.id
        JOIN 
            servicos s ON ord.servico_id = s.id;';
        $ordens = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        return $ordens;
    }

    public function getAllOrdens(): array{
        $sql = 'SELECT *
        FROM ordem_de_servico ';
        $ordens = $this->pdo->query($sql)->fetchAll(\PDO::FETCH_ASSOC);

        return $ordens;
    }

    public function insertOrdem(OrdemServicoModel $ordemM ){
        $sql = 'INSERT INTO ordem_de_servico (data_Inicio, cliente_id, animal_id, funcionario_id, servico_id,
         hora_inicio, hora_termino, duracao, data_Termino) values (:data_Inicio , :cliente_id, :animal_id, :funcionario_id, :servico_id,
         :hora_inicio, :hora_termino, :duracao, :data_Termino)';

        $stm = $this->pdo
        ->prepare($sql);

        $stm->execute([
            'data_Inicio' => $ordemM->getData_Inicio(),
            'cliente_id' => $ordemM->getCliente_id(),
            'animal_id' => $ordemM->getAnimal_id(),
            'funcionario_id' => $ordemM->getFuncionario_id(),
            'servico_id' => $ordemM->getServico_id(),
            'hora_inicio' => $ordemM->getHora_inicio(),
            'hora_termino' => $ordemM->getHora_termino(),
            'duracao' => $ordemM->getDuracao(),
            'data_Termino' => $ordemM->getData_Termino()
        ]);
    }
}