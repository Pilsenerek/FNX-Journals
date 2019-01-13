<?php
declare(strict_types=1);

namespace App\Controller;

use App\Repository\ArticleRepository;

/**
 * @todo split controller into pieces like article, user etc.
 * 
 * @author Michal Zbieranek
 */
class IndexController {

    /**
     * @return array
     */
    public function indexAction(): array {
        $filterLists = [
            'category_id',
            'tag_id',
            'author_id',
        ];
        $filter = array_intersect_key($_REQUEST, array_flip($filterLists));
        $data = [
            'articles' => $this->getArticleRepository()->getArticles($filter),
        ];

        return $data;
    }

    /**
     * @return array
     */
    public function articleAction(): array {
        $articleId = (int) $_REQUEST['id'];
        $article = $this->getArticleRepository()->getArticleById($articleId);

        return ['article' => $article];
    }

    /**
     * @return ArticleRepository
     */
    public function getArticleRepository(): ArticleRepository {

        return new ArticleRepository();
    }

}
