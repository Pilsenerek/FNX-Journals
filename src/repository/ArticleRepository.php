<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Article;
use App\Model\Category;
use App\Repository\AuthorRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use App\RepositoryAbstract;
use stdClass;

/**
 * @author Michal Zbieranek
 */
class ArticleRepository extends RepositoryAbstract {

    /**
     * @param int $id
     * @return Article
     */
    public function getArticleById(int $id): Article {
        $query = $this->pdo->prepare("select * from article where id=?");
        $query->execute([$id]);
        $article = $this->createArticleModel($query->fetchObject());

        return $article;
    }

    /**
     * @return array
     */
    public function getArticles(): array {
        $query = $this->pdo->prepare("select * from article");
        $query->execute();
        $articles = [];
        while ($stdClass = $query->fetchObject()) {
            $articles[] = $this->createArticleModel($stdClass);
        }

        return $articles;
    }

    /**
     * @param stdClass $stdClass
     * @return Article
     */
    private function createArticleModel(stdClass $stdClass) {
        $article = new Article();
        $article->setId((int) $stdClass->id);
        $article->setAuthors($this->fetchAuthors((int) $stdClass->id));
        if (!empty($stdClass->category_id)) {
            $article->setCategory($this->fetchCategory((int) $stdClass->category_id));
        }
        $article->setContent($stdClass->content);
        $article->setPrice((float) $stdClass->price);
        $article->setShortDescription($stdClass->short_description);
        $article->setTags($this->fetchTags((int) $stdClass->id));
        $article->setTitle($stdClass->title);

        //@todo consider whether this relation is necessary
        //$article->setUsers();

        return $article;
    }

    /**
     * @param int $categoryId
     * @return Category
     */
    private function fetchCategory(int $categoryId): Category {

        return $this->getCategoryRepository()->getCategoryById($categoryId);
    }

    /**
     * @param int $articleId
     * @return array
     */
    private function fetchAuthors(int $articleId): array {

        return $this->getAuthorRepository()->getAuthorsByArticleId($articleId);
    }

    /**
     * @param int $articleId
     * @return array
     */
    private function fetchTags(int $articleId): array {

        return $this->getTagRepository()->getTagsByArticleId($articleId);
    }

    /**
     * @return AuthorRepository
     */
    public function getAuthorRepository(): AuthorRepository {

        return new AuthorRepository();
    }

    /**
     * @return TagRepository
     */
    public function getTagRepository(): TagRepository {

        return new TagRepository();
    }

    /**
     * @return TagRepository
     */
    public function getCategoryRepository(): CategoryRepository {

        return new CategoryRepository();
    }

}
