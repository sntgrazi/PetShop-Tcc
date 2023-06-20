<?php

namespace App\Model;

final class UserModel{

    private $email;

    private $senha;

    

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
}