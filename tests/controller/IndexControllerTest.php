<?php

declare(strict_types=1);

namespace App\Test\Controller;

use App\Controller\IndexController;
use App\Model\Article;
use App\Model\Author;
use App\Model\Category;
use App\Model\Tag;
use App\Repository\ArticleRepository;
use App\Repository\AuthorRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Mockery;
use PDOException;
use PHPUnit\Framework\TestCase;

class IndexControllerTest extends TestCase {

    public function setUp() {
        $mockedArticle = $this->createMock(Article::class);
        $mockedArticleRepository = Mockery::mock('overload:'.ArticleRepository::class);
        $mockedArticleRepository->shouldReceive('getArticles')->times()->andReturn([$mockedArticle]);
        $mockedArticleRepository->shouldReceive('getArticleById')->times()->andReturn($mockedArticle);
        
        $mockedCategory = $this->createMock(Category::class);
        $mockedCategoryRepository = Mockery::mock('overload:'.CategoryRepository::class);
        $mockedCategoryRepository->shouldReceive('getCategories')->times()->andReturn([$mockedCategory]);
        
        $mockedAuthor = $this->createMock(Author::class);
        $mockedAuthorRepository = Mockery::mock('overload:'.AuthorRepository::class);
        $mockedAuthorRepository->shouldReceive('getAuthors')->times()->andReturn([$mockedAuthor]);
        $mockedAuthorRepository->shouldReceive('getAuthorById')->times()->andReturn($mockedAuthor);
        
        $mockedTag = $this->createMock(Tag::class);
        $mockedTagRepository = Mockery::mock('overload:'.TagRepository::class);
        $mockedTagRepository->shouldReceive('getTagsOrderByPopularity')->times()->andReturn([$mockedTag]);
    }
    
    /**
    * @runInSeparateProcess
    * @preserveGlobalState disabled
    */    
    public function testIndexAction() {
        $mock = $this->getIndexController();
        $this->assertIsArray($mock->indexAction());
        
        $_REQUEST['category_id'] = 999;
        $mock = $this->getIndexController();
        $this->assertIsArray($mock->indexAction());
        
        $this->noDbAction();
    }
    
    /**
    * @runInSeparateProcess
    * @preserveGlobalState disabled
    */
    public function testArticleAction() {
        $_REQUEST['id'] = 999;
        $mock = $this->getIndexController();
        $this->assertIsArray($mock->articleAction());
        $this->noDbAction();
    }

    /**
    * @runInSeparateProcess
    * @preserveGlobalState disabled
    */    
    public function testCategoriesAction() {
        $mock = $this->getIndexController();
        $this->assertIsArray($mock->categoriesAction());
    }
    
    /**
    * @runInSeparateProcess
    * @preserveGlobalState disabled
    */    
    public function testAuthorsAction(){
        $mock = $this->getIndexController();
        $this->assertIsArray($mock->authorsAction());
    }
    
    /**
    * @runInSeparateProcess
    * @preserveGlobalState disabled
    */    
    public function testAuthorDetailAction(){
        $_REQUEST['author_id'] = 999;
        $mock = $this->getIndexController();
        $this->assertIsArray($mock->authorDetailAction());
    }
    
    /**
    * @runInSeparateProcess
    * @preserveGlobalState disabled
    */    
    public function testTagsAction(){
        $mock = $this->getIndexController();
        $this->assertIsArray($mock->tagsAction());
    }
    
    private function noDbAction() {
        try {
            $this->assertIsArray($this->getIndexController()->indexAction());
        } catch (PDOException $exc) {
            $this->expectException(PDOException::class);
            $this->getIndexController()->indexAction();
        }
    }

    private function getIndexController(): IndexController {
        $indexController = new IndexController();

        return $indexController;
    }
    
    public function tearDown() {
        
        Mockery::close();
    }

}
