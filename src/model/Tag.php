<?php

declare(strict_types=1);

namespace App\Model;

use App\Model\Tag;

/**
 * @author Michal Zbieranek
 */
class Tag {

    /** $var int */
    private $id;

    /** $var string */
    private $name;

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

}
