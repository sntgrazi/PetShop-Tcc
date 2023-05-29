<?php

namespace App\Model;

final class OrdemServicoModel{

    private $id;

    private $data;

    private $cliente_id;

    private $animal_id;

    private $funcionario_id;

    private $servico_id;

    private $hora_inicio;

    private $hora_termino;

    private $duracao;

    private $status;

    
    public function getId(): int{
        return $this->id;
    }

    public function setId(int $id): OrdemServicoModel {
        $this->id = $id;

        return $this;
    }

    public function getData(): string{
        return $this->data;
    }

    public function setData(string $data): OrdemServicoModel{
        $this->data = $data;

        return $this;
    }

    public function getCliente_id(): int{
        return $this->cliente_id;
    }
 
    public function setCliente_id(int $cliente_id): OrdemServicoModel{
        $this->cliente_id = $cliente_id;

        return $this;
    }

    public function getAnimal_id(): int{
        return $this->animal_id;
    }
 
    public function setAnimal_id(int $animal_id): OrdemServicoModel{
        $this->animal_id = $animal_id;

        return $this;
    }

    public function getFuncionario_id(): int{
        return $this->funcionario_id;
    }

    public function setFuncionario_id(int $funcionario_id): OrdemServicoModel{
        $this->funcionario_id = $funcionario_id;

        return $this;
    }

    public function getServico_id(): int{
        return $this->servico_id;
    }

    public function setServico_id(int $servico_id): OrdemServicoModel{
        $this->servico_id = $servico_id;

        return $this;
    }

    public function getHora_inicio(): string{
        return $this->hora_inicio;
    }

    public function setHora_inicio(string $hora_inicio): OrdemServicoModel{
        $this->hora_inicio = $hora_inicio;

        return $this;
    }

    public function getHora_termino():string{
        return $this->hora_termino;
    }

    public function setHora_termino(string $hora_termino): OrdemServicoModel{
        $this->hora_termino = $hora_termino;

        return $this;
    }

    public function getDuracao(): string{
        return $this->duracao;
    }
 
    public function setDuracao(string $duracao): OrdemServicoModel{
        $this->duracao = $duracao;

        return $this;
    }

    public function getStatus(): string{
        return $this->status;
    }

    public function setStatus(string $status): OrdemServicoModel{
        $this->status = $status;

        return $this;
    }
}