<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Article;
use App\Model\Category;
use App\Repository\AuthorRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use App\RepositoryAbstract;
use PDOStatement;
use stdClass;

/**
 * @author Michal Zbieranek
 */
class ArticleRepository extends RepositoryAbstract {

    /** AuthorRepository */
    private $authorRepository;

    /** TagRepository */
    private $tagRepository;

    /** CategoryRepository */
    private $categoryRepository;

    public function __construct(\PDO $pdo = null) {
        parent::__construct($pdo);

        $this->authorRepository = new AuthorRepository();
        $this->tagRepository = new TagRepository();
        $this->categoryRepository = new CategoryRepository();
    }

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
     * @param array $filter [field => value]
     * @return array
     */
    public function getArticles(array $filter = []): array {
        $rawQuery = "select * from article";
        $query = $this->pdo->prepare($rawQuery);
        $queryWithCond = $this->prepareWhere($query, $filter);
        $queryWithCond->execute();
        $articles = [];
        while ($stdClass = $queryWithCond->fetchObject()) {
            $articles[] = $this->createArticleModel($stdClass);
        }

        return $articles;
    }

    /**
     * @param array $filter
     * @return string
     */
    private function prepareWhere(PDOStatement $pdoQuery, array $filter): PDOStatement {
        $rawQuery = $pdoQuery->queryString;
        if (!empty($filter)) {
            $where = " where ";
            $wheres = $this->prepareWhereChunks($filter);
            $where .= join(" and ", $wheres);
            $rawQuery .= $where;
        }
        $newPdo = $this->pdo->prepare($rawQuery);
        foreach ($filter as $field => $value) {
            $newPdo->bindParam(':' . $field, $value);
        }

        return $newPdo;
    }

    /**
     * @param array $filter
     * @return array
     */
    private function prepareWhereChunks(array $filter): array {
        $relatedFields = [
            'author_id' => 'id in(select article_id from article_has_author where author_id=:author_id)',
            'tag_id' => 'id in(select article_id from article_has_tag where tag_id=:tag_id)',
            'user_id' => 'id in(select article_id from article_has_user where user_id=:user_id)',
        ];
        foreach ($filter as $field => $value) {
            if (array_key_exists($field, $relatedFields)) {
                $wheres[] = $relatedFields[$field];
            } else {
                $wheres[] = $field . " = :" . $field;
            }
        }

        return $wheres;
    }

    /**
     * @param stdClass $stdClass
     * @return Article
     */
    private function createArticleModel(stdClass $stdClass): Article {
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

        return $article;
    }

    /**
     * @param int $categoryId
     * @return Category
     */
    private function fetchCategory(int $categoryId): Category {

        return $this->categoryRepository->getCategoryById($categoryId);
    }

    /**
     * @param int $articleId
     * @return array
     */
    private function fetchAuthors(int $articleId): array {

        return $this->authorRepository->getAuthorsByArticleId($articleId);
    }

    /**
     * @param int $articleId
     * @return array
     */
    private function fetchTags(int $articleId): array {

        return $this->tagRepository->getTagsByArticleId($articleId);
    }

}
