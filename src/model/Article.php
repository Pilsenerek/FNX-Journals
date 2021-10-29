<?php
declare(strict_types=1);

namespace App\Model;

/**
 * @todo implement collection objects interface (->add, ->clear, ->filter etc.)
 * 
 * @author Michal Zbieranek
 */
class Article {

    /** $var int */
    private $id;

    /** $var string */
    private $title;

    /** $var string */
    private $shortDescription;

    /** $var string */
    private $content;

    /** $var float */
    private $price = 0;

    /** @var Category */
    private $category = null;

    /** @var array */
    private $authors;

    /** array */
    private $tags;

    /**
     * @return int
     */
    public function getId(): int {

        return $this->id;
    }

    /**
     * @param int $id
     * @return Article
     */
    public function setId(int $id): Article {
        $this->id = $id;

        return $this;
    }

    /**
     * @return string
     */
    public function getTitle(): string {

        return $this->title;
    }

    /**
     * @return string
     */
    public function getShortDescription(): string {

        return $this->shortDescription;
    }

    /**
     * @return string
     */
    public function getContent(): string {

        return $this->content;
    }

    /**
     * @return float
     */
    public function getPrice(): float {

        return $this->price;
    }

    /**
     * @return Category
     */
    public function getCategory(): ?Category {

        return $this->category;
    }

    /**
     * @return array
     */
    public function getTags(): array {

        return $this->tags;
    }

    /**
     * @param string $title
     * @return Article
     */
    public function setTitle(string $title): Article {
        $this->title = $title;

        return $this;
    }

    /**
     * @param string $shortDescription
     * @return Article
     */
    public function setShortDescription(string $shortDescription): Article {
        $this->shortDescription = $shortDescription;

        return $this;
    }

    /**
     * @param string $content
     * @return Article
     */
    public function setContent(string $content): Article {
        $this->content = $content;

        return $this;
    }

    /**
     * @param float $price
     * @return Article
     */
    public function setPrice(float $price): Article {
        $this->price = $price;

        return $this;
    }

    /**
     * @param Category $category
     * @return Article
     */
    public function setCategory(Category $category = null): Article {
        $this->category = $category;

        return $this;
    }

    /**
     * @param type $tags
     * @return Article
     */
    public function setTags($tags): Article {
        $this->tags = $tags;

        return $this;
    }

    /**
     * @return array
     */
    public function getAuthors(): array {

        return $this->authors;
    }

    /**
     * @param array $authors
     * @return Article
     */
    public function setAuthors(array $authors): Article {
        $this->authors = $authors;

        return $this;
    }

    /**
     * @return bool
     */
    public function isFree(): bool {
        if (empty($this->getPrice())) {

            return true;
        }

        return false;
    }

}
