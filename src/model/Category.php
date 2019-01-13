<?php
declare(strict_types=1);

namespace App\Model;

use App\Model\Category;

/**
 * @author Michal Zbieranek
 */
class Category {

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
     * @return Category
     */
    public function setId(int $id): Category {
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
     * @return Category
     */
    public function setName(string $name): Category {
        $this->name = $name;

        return $this;
    }

}
