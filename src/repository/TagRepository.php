<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Tag;
use App\RepositoryAbstract;
use stdClass;

/**
 * @author Michal Zbieranek
 */
class TagRepository extends RepositoryAbstract {

    /**
     * @param int $id
     * @return Tag
     */
    public function getTagsByArticleId(int $articleId): array {
        $query = $this->pdo->prepare(
                "select * from tag where id in(
                    select tag_id from article_has_tag where article_id=?
                )"
        );
        $query->execute([$articleId]);
        $tags = [];
        while ($stdClass = $query->fetchObject()) {
            $tags[] = $this->createTagModel($stdClass);
        }

        return $tags;
    }

    /**
     * @param stdClass $stdClass
     * @return Tag
     */
    private function createTagModel(stdClass $stdClass) {
        $tag = new Tag();
        $tag->setId((int)$stdClass->id);
        $tag->setName($stdClass->name);

        return $tag;
    }

}
