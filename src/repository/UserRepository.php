<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\User;
use App\RepositoryAbstract;
use stdClass;

/**
 * @author Michal Zbieranek
 */
class UserRepository extends RepositoryAbstract {


    /**
     * @param string $username
     * @param string $password
     * @return User|null
     */
    public function getUserAuth(string $username, string $password): ?User {
        $query = $this->pdo->prepare(
                "select * from user where username=? and password=?"
        );
        $query->execute([$username, $password]);
        $result = $query->fetchObject();
        if ($result) {

            return $this->createUserModel($result);
        } else {
            return null;
        }
    }

    /**
     * @param stdClass $stdClass
     * @return User
     */
    private function createUserModel(stdClass $stdClass) {
        $user = new User();
        $user->setId((int) $stdClass->id);
        $user->setUsername($stdClass->username);
        $user->setPassword($stdClass->password);
        $user->setWallet((float) $stdClass->wallet);

        return $user;
    }

}
