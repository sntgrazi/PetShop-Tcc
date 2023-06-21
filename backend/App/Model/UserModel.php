<?php

namespace App\Model;

final class UserModel{

    private $email;

    private $senha;

    private $senhaAcesso;

    public function getEmail(): string{
        return $this->email;
    }


    public function setEmail(string $email): UserModel{
        $this->email = $email;

        return $this;
    }

    public function getSenha(): string{
        return $this->senha;
    }

    public function setSenha(string $senha): UserModel{
        $this->senha = $senha;

        return $this;
    }

    /**
     * Get the value of senhaAcesso
     */ 
    public function getSenhaAcesso(): string{
        return $this->senhaAcesso;
    }

 
    public function setSenhaAcesso(string $senhaAcesso): UserModel{
        $this->senhaAcesso = $senhaAcesso;

        return $this;
    }
}