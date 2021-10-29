<?php
declare(strict_types=1);

namespace App\Model;

/**
 * @author Michal Zbieranek
 */
class Tag {

    /** $var int */
    private $id;

    /** $var string */
    private $name;

    /**
     * Not mapped in DB
     * 
     * @var int
     */
    private $numberOfArticles = null;

    /**
     * @return int
     */
    public function getId(): int {

        return $this->id;
    }

    /**
     * @param int $id
     * @return Tag
     */
    public function setId(int $id): Tag {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getName(): string {

        return $this->name;
    }

    /**
     * @param string $name
     * @return Tag
     */
    public function setName(string $name): Tag {
        $this->name = $name;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getNumberOfArticles(): ?int {

        return $this->numberOfArticles;
    }

    /**
     * @param int $numberOfArticles
     * @return Tag
     */
    public function setNumberOfArticles(int $numberOfArticles): Tag {
        $this->numberOfArticles = $numberOfArticles;

        return $this;
    }

}
