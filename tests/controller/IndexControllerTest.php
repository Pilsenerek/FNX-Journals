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
use App\Repository\UserRepository;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class IndexControllerTest extends TestCase {

    private $auth;

    public function setUp() {
        $mockedArticle = $this->createMock(Article::class);
        $mockedArticle->expects($this->any())->method('isFree')->willReturn(false);
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
        
        Mockery::mock('overload:' . UserRepository::class)->shouldReceive('buyArticle')->times()->andReturn(true);
    }

    /**
     * @preserveGlobalState disabled
     */
    public function testIndexAction() {
        $this->assertArrayHasKey('articles', $this->getIndexController()->indexAction());
    }

    /**
     * @preserveGlobalState disabled
     */
    public function testArticleAction() {
        $_REQUEST['id'] = 999;
        $this->assertArrayHasKey('article', $this->getIndexController()->articleAction());
    }

    /**
     * @preserveGlobalState disabled
     */
    public function testCategoriesAction() {
        $this->assertArrayHasKey('categories', $this->getIndexController()->categoriesAction());
    }

    /**
     * @preserveGlobalState disabled
     */
    public function testAuthorsAction() {
        $this->assertArrayHasKey('authors', $this->getIndexController()->authorsAction());
    }

    /**
     * @preserveGlobalState disabled
     */
    public function testAuthorDetailAction() {
        $_REQUEST['author_id'] = 999;
        $this->assertArrayHasKey('author', $this->getIndexController()->authorDetailAction());
        $this->assertArrayHasKey('articles', $this->getIndexController()->authorDetailAction());
    }

    /**
     * @preserveGlobalState disabled
     */
    public function testTagsAction() {
        $this->assertArrayHasKey('tags', $this->getIndexController()->tagsAction());
    }

    /**
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
     * @preserveGlobalState disabled
     */
    public function testLogoutAction() {
        $mock = $this->getIndexController();
        $this->assertNull($mock->logoutAction());
    }

    /**
     * @preserveGlobalState disabled
     */
    public function testBuyAction() {
        $_REQUEST['article_id'] = 999;
        $_REQUEST['url_back'] = '/wfefwe?wfwef=wefwef';
        $mockedUser = $this->createMock(User::class);
        $mockedUser->expects($this->any())->method('canAfford')->willReturn(true);
        $this->auth->shouldReceive('getUser')->times()->andReturn($mockedUser);
        $this->auth->shouldReceive('refresh')->times()->andReturn(null);
        $this->getIndexController()->buyAction();
        $this->assertNull($this->getIndexController()->buyAction());
    }

    /**
     * @preserveGlobalState disabled
     */
    public function testBuyActionFail() {
        $_REQUEST['article_id'] = 999;
        $_REQUEST['url_back'] = '/wfefwe?wfwef=wefwef';
        $mockedUser = $this->createMock(User::class);
        $mockedUser->expects($this->any())->method('canAfford')->willReturn(false);
        $this->auth->shouldReceive('getUser')->times()->andReturn($mockedUser);
        $this->auth->shouldReceive('refresh')->times()->andReturn(null);
        $this->expectException(Exception::class);
        $this->getIndexController()->buyAction();
    }

    
    private function getIndexController(): IndexController {
        $indexController = new IndexController();

        return $indexController;
    }

    public function tearDown() {

        Mockery::close();
    }

}
