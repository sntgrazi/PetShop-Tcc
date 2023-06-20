<?php

namespace App\DAO;
use App\Model\UserModel;

class UserDAO extends ConexaoDAO{

    public function __construct(){
        parent::__construct();
    }

    public function getUserByEmail(UserModel $userM){

        $sql = 'SELECT * from usuarios WHERE email = :email';

        $stm = $this->pdo->prepare($sql);
        $stm->execute([
            'email' => $userM->getEmail()
        ]);
        $user = $stm->fetch(\PDO::FETCH_ASSOC);
        return $user;

    }
}