<?php

namespace App\DAO;

use App\Model\OrdemServicoModel;

class OrdemServicoDAO extends ConexaoDAO{
    public function __construct(){
        parent::__construct();
    }

    public function getOrdensById(OrdemServicoModel $ordemM): array{
        $sql = 'SELECT 
        ord.id,
        ord.data_inicio, 
        ord.data_termino, 
        ord.hora_inicio, 
        ord.hora_termino, 
        ord.duracao, 
        ord.status,
        an.id AS animal_id,
        an.nome_pet AS nome_animal,
        f.id AS funcionario_id,
        f.nome AS nome_funcionario,
        c.id AS cliente_id,
        c.nome AS nome_cliente, 
        s.id AS servico_id,
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
        servicos s ON ord.servico_id = s.id
    WHERE
        ord.id = :id;';
            
        $stm = $this->pdo->prepare($sql);
        $stm->execute([
                'id' => $ordemM->getId()
            ]);
        $ordem = $stm->fetch(\PDO::FETCH_ASSOC);
            
        return $ordem;

    }

    public function getAllOrdens(): array{
        $sql = 'SELECT ordem_de_servico.*, servicos.nome_servico, servicos.valor
        FROM ordem_de_servico
        JOIN servicos ON ordem_de_servico.servico_id = servicos.id;';
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

    public function updateStatus(OrdemServicoModel $ordemM){
        $sql = 'UPDATE ordem_de_servico SET status = :status WHERE id = :id';

        $stm = $this->pdo->prepare($sql);

        $stm -> execute([
            'status' =>$ordemM->getStatus(),
            'id' =>$ordemM->getId()
        ]);
    }

    public function updateOrdem(OrdemServicoModel $ordemM): void {
        $sql = 'UPDATE ordem_de_servico SET data_Inicio = :data_Inicio,  cliente_id = :cliente_id , animal_id = :animal_id, funcionario_id = :funcionario_id, servico_id = :servico_id, hora_inicio = :hora_inicio, hora_termino = :hora_termino ,duracao = :duracao, data_Termino = :data_Termino  WHERE id = :id';

        $stm = $this->pdo->prepare($sql);

        $stm->execute([
            'data_Inicio' => $ordemM->getData_Inicio(),
            'cliente_id' => $ordemM->getCliente_id(),
            'animal_id' => $ordemM->getAnimal_id(),
            'funcionario_id' => $ordemM->getFuncionario_id(),
            'servico_id' => $ordemM->getServico_id(),
            'hora_inicio' => $ordemM->getHora_inicio(),
            'hora_termino' => $ordemM->getHora_termino(),
            'duracao' => $ordemM->getDuracao(),
            'data_Termino' => $ordemM->getData_Termino(),
            'id' => $ordemM->getId()
        ]);
    }

    public function deleteOrdem(OrdemServicoModel $ordemM){
        $sql = 'DELETE from ordem_de_servico WHERE id = :id';

        $stm = $this->pdo->prepare($sql);

        $stm->execute(['id' => $ordemM->getId()]);
    }
}