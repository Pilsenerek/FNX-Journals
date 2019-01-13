<?php
declare(strict_types=1);

namespace App\Model;

use App\Model\User;

/**
 * @author Michal Zbieranek
 */
class User {

    /** $var int */
    private $id;

    /** $var string */
    private $username;

    /** $var string */
    private $password;

    /** $var float */
    private $wallet;

    /**
     * @return int
     */
    public function getId(): int {

        return $this->id;
    }

    /**
     * @param int $id
     * @return User
     */
    public function setId(int $id): User {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string {

        return $this->username;
    }

    /**
     * @return string
     */
    public function getPassword(): string {

        return $this->password;
    }

    /**
     * @return float
     */
    public function getWallet(): float {

        return $this->wallet;
    }

    /**
     * @param type $username
     * @return User
     */
    public function setUsername(string $username): User {
        $this->username = $username;

        return $this;
    }

    /**
     * @param type $password
     * @return User
     */
    public function setPassword(string $password): User {
        $this->password = $password;

        return $this;
    }

    /**
     * @param float $wallet
     * @return User
     */
    public function setWallet(float $wallet = 0): User {
        $this->wallet = $wallet;

        return $this;
    }

}
