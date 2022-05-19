<?php

declare(strict_types=1);

namespace App\Test\Repository;

use App\Model\Article;
use App\Repository\ArticleRepository;
use App\Repository\AuthorRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use Mockery;
use PDO;
use PDOException;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use stdClass;

/**
 * @runTestsInSeparateProcesses
 */
class ArticleRepositoryTest extends TestCase {

    public function setUp() {
        Mockery::mock('overload:'.AuthorRepository::class)
                ->shouldReceive('getAuthorsByArticleId')
                ->once()
                ->andReturn([$this->createMock(\App\Model\Author::class)])
        ;
        
        Mockery::mock('overload:'.CategoryRepository::class)
                ->shouldReceive('getCategoryById')
                ->times()
                ->andReturn($this->createMock(\App\Model\Category::class))
        ;
        
        Mockery::mock('overload:'.TagRepository::class)
                ->shouldReceive('getTagsByArticleId')
                ->once()
                ->andReturn([$this->createMock(\App\Model\Tag::class)])
        ;
    }
    
    /**
    * @preserveGlobalState disabled
    */   
    public function testGetArticleById() {
        $articleRepository = $this->getArticleRepository();
        $this->assertInstanceOf(Article::class, $articleRepository->getArticleById(999));

        //test article with empty category
        $articleRepository = $this->getArticleRepository(false, false);
        $this->assertInstanceOf(Article::class, $articleRepository->getArticleById(999));
    }

    /**
    * @preserveGlobalState disabled
    */   
    public function testGetArticles() {
        $articleRepository = $this->getArticleRepository(true);
        $this->assertInstanceOf(Article::class, $articleRepository->getArticles()[0]);

        //with filter
        $articleRepository = $this->getArticleRepository(true);
        $this->assertInstanceOf(Article::class, $articleRepository->getArticles(['wefwefee' => 'wefwef wefwf'])[0]);
        
        $articleRepository = $this->getArticleRepository(true);
        $this->assertInstanceOf(Article::class, $articleRepository->getArticles(['tag_id' => 'wefwef wefwf'])[0]);
    }
    
    private function getArticleRepository($manyArticles = false, $withCategory = true): ArticleRepository {
        $pdo = $this->getMockedPDO($manyArticles, $withCategory);
        $articleRepository = new ArticleRepository($pdo);

        return $articleRepository;
    }
    
    protected function getMockedPDO($manyArticles, $withCategory) {
        $mockedReturn = new stdClass();
        $mockedReturn->id = 123;
        if ($withCategory) {
            $mockedReturn->category_id = 123;
        } else {
            $mockedReturn->category_id = null;
        }
        $mockedReturn->title = 'éfwef wefwef wefwe';
        $mockedReturn->content = 'éfwef wefwef wefwe';
        $mockedReturn->price = 999.99;
        $mockedReturn->short_description = 'éfwef wefwef wefwe';

        $mockedExecute = $this
                ->getMockBuilder(PDOStatement::class)
                ->setMethods(['execute', 'fetchObject'])
                ->getMock()
        ;
        $mockedExecute
                ->expects($this->any())->method('execute')
                ->willReturn(true)
        ;
        $mockedExecute
                ->expects($this->at(1))->method('fetchObject')
                ->willReturn($mockedReturn)
        ;
        if ($manyArticles) {
            $mockedExecute
                    ->expects($this->at(2))->method('fetchObject')
                    ->willReturn(false)
            ;
        }

        $mockedPDO = $this->getMockBuilder(PDO::class)
                ->disableOriginalConstructor()
                ->setMethods(['prepare', 'execute', 'fetchObject'])
                ->getMock()
        ;
        $mockedPDO
                ->expects($this->any())
                ->method('prepare')
                ->willReturn($mockedExecute)
        ;

        return $mockedPDO;
    }

    public function tearDown() {
        
        Mockery::close();
    }
}
