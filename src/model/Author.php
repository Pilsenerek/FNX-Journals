<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Author;

/**
 * @author Michal Zbieranek
 */
class Author {

    /** $var int */
    private $id;

    /** $var string */
    private $firstName;

    /** $var string */
    private $lastName;

    /** $var string */
    private $about;

    /**
     * @return int
     */
    public function getId(): int {

        return $this->id;
    }

    /**
     * @param int $id
     * @return Author
     */
    public function setId(int $id): Author {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getFirstName(): string {

        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string {

        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getAbout(): ?string {

        return $this->about;
    }

    /**
     * @param string $firstName
     * @return Author
     */
    public function setFirstName(string $firstName): Author {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @param string $lastName
     * @return Author
     */
    public function setLastName(string $lastName): Author {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @param string $about
     * @return Author
     */
    public function setAbout(string $about = null): Author {
        $this->about = $about;

        return $this;
    }

    /**
     * @return string
     */
    public function getFullName(): string {

        return $this->firstName . ' ' . $this->lastName;
    }

}
