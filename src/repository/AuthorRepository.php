<?php
declare(strict_types=1);

namespace App\Repository;

use App\Model\Author;
use App\RepositoryAbstract;
use stdClass;

/**
 * @author Michal Zbieranek
 */
class AuthorRepository extends RepositoryAbstract {

    /**
     * @param int $articleId
     * @return array [Author]
     */
    public function getAuthorsByArticleId(int $articleId): array {
        $query = $this->pdo->prepare(
                "select * from author where id in(
                    select author_id from article_has_author where article_id=?
                )"
        );
        $query->execute([$articleId]);
        $authors = [];

        while ($stdClass = $query->fetchObject()) {
            $authors[] = $this->createAuthorModel($stdClass);
        }

        return $authors;
    }

    /**
     * @param stdClass $stdClass
     * @return Author
     */
    private function createAuthorModel(stdClass $stdClass) {
        $author = new Author();
        $author->setId((int)$stdClass->id);
        $author->setFirstName($stdClass->first_name);
        $author->setLastName($stdClass->last_name);
        $author->setAbout($stdClass->about);

        return $author;
    }

}
