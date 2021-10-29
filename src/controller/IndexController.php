<?php

declare(strict_types=1);

namespace App\Controller;

use App\Auth;
use App\Repository\ArticleRepository;
use App\Repository\AuthorRepository;
use App\Repository\CategoryRepository;
use App\Repository\ChatRepository;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use Exception;

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

    /** @var UserRepository */
    private $userRepository;

    /** @var ChatRepository */
    private $chatRepository;

    public function __construct() {
        $this->articleRepository = new ArticleRepository();
        $this->categoryRepository = new CategoryRepository();
        $this->authorRepository = new AuthorRepository();
        $this->tagRepository = new TagRepository();
        $this->auth = new Auth();
        $this->userRepository = new UserRepository();
        $this->chatRepository = new ChatRepository();
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
    public function chatAction(): array {
        $data = [
            'messages' => $this->chatRepository->getUnreadMessages(),
        ];

        return $data;
    }

    public function chatAddMessageAction() {
        $user = $this->auth->getUser();
        $this->chatRepository->addMessage($_POST['message'], $user);
    }

    public function chatSentEventAction() {
        ob_start();
        $name = 'chat';
        $id = 0;

        @ini_set('zlib.output_compression', "0");
        @ini_set('implicit_flush', "1");
        @ob_end_clean();
        set_time_limit(0);
        header('Content-type: text/event-stream; charset=utf-8');
        header("Cache-Control: no-cache, must-revalidate");
        header('X-Accel-Buffering: no');


        while (true) {
            static $i = 0;
            if($i == 10){

                trigger_error('test '.$i, E_USER_WARNING);
                //throw new Exception('Sky is a limit!');
            }
            //$mes = $messages->getUnreadMessages();
            $mes = [
                ['username'=>'Ziomek', 'message' => $i.': '.date('h:i:s').' testowy mesedż '],
            ];
            if (!empty($mes)) {
                foreach ($mes as $message) {
                    //$message['message'] = $i.': '.$message['message'];
                    $data = json_encode($message);
                    echo "event: {$name}\r\nid: {$id}\r\ndata: $data\r\n\r\n";
                    $id++;
                    //$stream->send($message);
                }
            }
            $i++;
            flush();
            if (connection_aborted()) {
                break;
            }
            //usleep(200000);
            sleep(1);
        }


        ob_end_clean();
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
    public function logoutAction(): void {
        if ($this->auth->logout()) {

            header('Location: ' . '/?a=login');
        }
    }

    /**
     * @return void
     */
    public function buyAction(): void {
        $articleId = (int) $_REQUEST['article_id'];
        $urlBack = $_REQUEST['url_back'];
        $user = $this->auth->getUser();
        $article = $this->articleRepository->getArticleById($articleId);
        if ($article->isFree() || !$user->canAfford($article)) {

            throw new Exception('You can not buy this article');
        }
        $this->userRepository->buyArticle($article, $user);
        $this->auth->refresh();
        header('Location: ' . $urlBack);
    }

}
