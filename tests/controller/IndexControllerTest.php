<?php

declare(strict_types=1);

namespace App\Test\Controller;

use App\Auth;
use App\Controller\IndexController;
use App\Model\Article;
use App\Model\Author;
use App\Model\Category;
use App\Model\Tag;
use App\Model\User;
use App\Repository\ArticleRepository;
use App\Repository\AuthorRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Mockery;
use PHPUnit\Framework\TestCase;

class IndexControllerTest extends TestCase {

    private $auth;

    public function setUp() {
        $mockedArticle = $this->createMock(Article::class);
        $mockedArticleRepository = Mockery::mock('overload:' . ArticleRepository::class);
        $mockedArticleRepository->shouldReceive('getArticles')->times()->andReturn([$mockedArticle]);
        $mockedArticleRepository->shouldReceive('getArticleById')->times()->andReturn($mockedArticle);

        $mockedCategory = $this->createMock(Category::class);
        $mockedCategoryRepository = Mockery::mock('overload:' . CategoryRepository::class);
        $mockedCategoryRepository->shouldReceive('getCategories')->times()->andReturn([$mockedCategory]);

        $mockedAuthor = $this->createMock(Author::class);
        $mockedAuthorRepository = Mockery::mock('overload:' . AuthorRepository::class);
        $mockedAuthorRepository->shouldReceive('getAuthors')->times()->andReturn([$mockedAuthor]);
        $mockedAuthorRepository->shouldReceive('getAuthorById')->times()->andReturn($mockedAuthor);

        $mockedTag = $this->createMock(Tag::class);
        $mockedTagRepository = Mockery::mock('overload:' . TagRepository::class);
        $mockedTagRepository->shouldReceive('getTagsOrderByPopularity')->times()->andReturn([$mockedTag]);

        $this->auth = Mockery::mock('overload:' . Auth::class);
        $this->auth->shouldReceive('logout')->times()->andReturn(true);
    }

    public function testIndexAction() {
        $this->assertArrayHasKey('articles', $this->getIndexController()->indexAction());
    }

    public function testArticleAction() {
        $_REQUEST['id'] = 999;
        $this->assertArrayHasKey('article', $this->getIndexController()->articleAction());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testCategoriesAction() {
        $this->assertArrayHasKey('categories', $this->getIndexController()->categoriesAction());
    }

    public function testAuthorsAction() {
        $this->assertArrayHasKey('authors', $this->getIndexController()->authorsAction());
    }

    public function testAuthorDetailAction() {
        $_REQUEST['author_id'] = 999;
        $this->assertArrayHasKey('author', $this->getIndexController()->authorDetailAction());
        $this->assertArrayHasKey('articles', $this->getIndexController()->authorDetailAction());
    }

    public function testTagsAction() {
        $this->assertArrayHasKey('tags', $this->getIndexController()->tagsAction());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testLoginAction() {
        //empty post
        $_POST = [];
        $this->assertIsArray($this->getIndexController()->loginAction());

        //good credentials
        $_POST['username'] = 'wewefwef';
        $_POST['password'] = 'wewefwef fweff';
        $mockedUser = $this->createMock(User::class);
        $this->auth->shouldReceive('authenticate')->times()->andReturn([$mockedUser]);
        $this->assertNull($this->getIndexController()->loginAction());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testLoginActionFail() {
        $this->auth->shouldReceive('authenticate')->once()->andReturn(null);
        $_POST['username'] = 'wewefwef';
        $_POST['password'] = 'wewefwef fweff';
        $mock = $this->getIndexController();
        $this->assertArrayHasKey('error', $mock->loginAction());
    }

    /**
     * @runInSeparateProcess
     * @preserveGlobalState disabled
     */
    public function testLogoutAction() {
        $mock = $this->getIndexController();
        $this->assertNull($mock->logoutAction());
    }

    private function getIndexController(): IndexController {
        $indexController = new IndexController();

        return $indexController;
    }

    public function tearDown() {

        Mockery::close();
    }

}
