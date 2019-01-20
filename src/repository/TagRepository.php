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
     * @param int $articleId
     * @return array
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
     * @return array
     */
    public function getTagsOrderByPopularity(): array {
        $query = $this->pdo->prepare(
                "select *,(
                    select count(article_id) 
                    from article_has_tag 
                    where tag_id=tag.id 
                    group by tag_id limit 1
                ) as number_of_articles
                from tag
                order by number_of_articles DESC
                "
        );
        $query->execute();
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
    private function createTagModel(stdClass $stdClass): Tag {
        $tag = new Tag();
        $tag->setId((int) $stdClass->id);
        $tag->setName($stdClass->name);
        if (!empty($stdClass->number_of_articles)) {
            $tag->setNumberOfArticles((int) $stdClass->number_of_articles);
        }

        return $tag;
    }

}
