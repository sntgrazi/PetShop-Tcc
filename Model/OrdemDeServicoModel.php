<?php

namespace App\Model;

final class OrdemDeServicoModel {

    private $id;

    private $dataOrdemServico;

    private $animalId;

    private $colaboradorId;

    private $clienteId;

    private $servicoId;

    private $horaInicio;

    private $horaTermino;

    private $status;

    public function getId(): int {
        return $this->id;
    }

    public function setId(int $id): OrdemDeServicoModel {
        $this->id = $id;
        return $this;
    }

    public function getDataOrdemServico(): string {
        return $this->dataOrdemServico;
    }

    public function setDataOrdemServico(string $dataOrdemServico): OrdemDeServicoModel {
        $this->dataOrdemServico = $dataOrdemServico;
        return $this;
    }

    public function getAnimalId(): int {
        return $this->animalId;
    }

    public function setAnimalId(int $animalId): OrdemDeServicoModel {
        $this->animalId = $animalId;
        return $this;
    }

    public function getColaboradorId(): int {
        return $this->colaboradorId;
    }

    public function setColaboradorId(int $colaboradorId): OrdemDeServicoModel {
        $this->colaboradorId = $colaboradorId;
        return $this;
    }

    public function getClienteId(): int {
        return $this->clienteId;
    }

    public function setClienteId(int $clienteId): OrdemDeServicoModel {
        $this->clienteId = $clienteId;
        return $this;
    }

    public function getServicoId(): int {
        return $this->servicoId;
    }

    public function setServicoId(int $servicoId): OrdemDeServicoModel {
        $this->servicoId = $servicoId;
        return $this;
    }

    public function getHoraInicio(): string {
        return $this->horaInicio;
    }

    public function setHoraInicio(string $horaInicio): OrdemDeServicoModel {
        $this->horaInicio = $horaInicio;
        return $this;
    }

    public function getHoraTermino(): string {
        return $this->horaTermino;
    }

    public function setHoraTermino(string $horaTermino): OrdemDeServicoModel {
        $this->horaTermino = $horaTermino;
        return $this;
    }

    public function getStatus(): string {
        return $this->status;
    }

    public function setStatus(string $status): OrdemDeServicoModel {
        $this->status = $status;
        return $this;
    }

}
