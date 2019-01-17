<?php
declare(strict_types=1);

namespace App\Controller;

use App\Auth;
use App\Repository\ArticleRepository;
use App\Repository\AuthorRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;

/**
 * @todo split controller into pieces like article, user etc.
 * 
 * @author Michal Zbieranek
 */
class IndexController {

    
    /** @var ArticleRepository */
    private $articleRepository;
    
    /** @var CategoryRepository */
    private $categoryRepository;
    
    /** @var AuthorRepository */
    private $authorRepository;
    
    /** @var TagRepository */
    private $tagRepository;
    
    /** @var Auth */
    private $auth;

    public function __construct() {
        $this->articleRepository = new ArticleRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->authorRepository = new AuthorRepository();
        $this->tagRepository = new TagRepository();
        $this->auth = new Auth();
    }

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
            'articles' => $this->articleRepository->getArticles($filter),
        ];

        return $data;
    }

    /**
     * @return array
     */
    public function authorsAction(): array {
        $data = [
            'authors' => $this->authorRepository->getAuthors()
        ];

        return $data;
    }
    
    /**
     * @return array
     */
    public function authorDetailAction(): array {
        $authorId = (int) $_REQUEST['author_id'];
        $data = [
            'author' => $this->authorRepository->getAuthorById($authorId),
            'articles' => $this->articleRepository->getArticles(['author_id' => $authorId]),
        ];

        return $data;
    }

    /**
     * @return array
     */
    public function articleAction(): array {
        $articleId = (int) $_REQUEST['id'];
        $article = $this->articleRepository->getArticleById($articleId);

        return ['article' => $article];
    }

    /**
     * @return array
     */
    public function categoriesAction(): array {
        $data = [
            'categories' => $this->categoryRepository->getCategories(),
        ];

        return $data;
    }
    
    /**
     * @return array
     */
    public function tagsAction(): array {
        $data = [
            'tags' => $this->tagRepository->getTagsOrderByPopularity(),
        ];

        return $data;
    }
    
    /**
     * @return array
     */
    public function loginAction() {
        if (empty($_POST)) {

            return [];
        } else {
            $user = $this->auth->authenticate($_POST['username'], $_POST['password']);
            if ($user) {
                header('Location: ' . '/');
            } else {

                return ['error' => true];
            }
        }
    }

    /**
     * @return array
     */
    public function logoutAction() : void {
        if ($this->auth->logout()) {

            header('Location: ' . '/?a=login');
        }
    }

}
