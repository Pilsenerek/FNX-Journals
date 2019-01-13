<?php

declare(strict_types=1);

namespace App\Test\Repository;

use App\Model\Article;
use App\Repository\ArticleRepository;
use App\Repository\AuthorRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;
use stdClass;

class ArticleRepositoryTest extends TestCase {

    public function testGetArticleById() {
        $articleRepository = $this->getArticleRepository();
        //$articleRepository->setPdo($this->getMockedPDO(false, ));
        
        $this->assertInstanceOf(Article::class, $articleRepository->getArticleById(999));
        
        //test article with empty category
        $articleRepository = $this->getArticleRepository(false, false);
        $this->assertInstanceOf(Article::class, $articleRepository->getArticleById(999));
    }

    public function testGetArticles() {
        $articleRepository = $this->getArticleRepository(true);
        $this->assertInstanceOf(Article::class, $articleRepository->getArticles()[0]);
    }

    public function testNoCategoryRepository() {
        $this->noRepository('getCategoryRepository');
    }

    public function testNoAuthorRepository() {
        $this->noRepository('getAuthorRepository');
    }

    public function testNoTagRepository() {
        $this->noRepository('getTagRepository');
    }

     public function testConstructorWithPdo(){
        $articleRepository = new ArticleRepository(new \PDO('sqlite::memory:'));
        $this->assertInstanceOf(ArticleRepository::class, $articleRepository);
    }
    
    private function noRepository($method){
        try {
            $this->assertInstanceOf(\App\RepositoryAbstract::class ,$this->getPureArticleRepository()->$method());
        } catch (PDOException $exc) {
            $this->expectException(PDOException::class);
            $this->getPureArticleRepository()->$method();
        }        
    }
    
    private function getPureArticleRepository(){
                    $articleRepository = $this->getMockBuilder(ArticleRepository::class)
                ->setMethods(null)
                ->disableOriginalConstructor()
                ->getMock()
            ;
                    
                    return $articleRepository;
    }
    
    private function getArticleRepository($manyArticles = false, $withCategory = true): ArticleRepository {
        //$articleRepository = new ArticleRepository();
        $articleRepository = $this->getMockBuilder(ArticleRepository::class)
            ->setMethods(['getAuthorRepository', 'getTagRepository', 'getCategoryRepository'])
            ->disableOriginalConstructor()
            ->getMock()
        ;
        //$articleRepository->setPdo($this->getMockedPDO());
        
        $mockedCategoryRepository = $this->getMockBuilder(CategoryRepository::class)->disableOriginalConstructor()->getMock();
        $articleRepository->expects($this->any())->method('getCategoryRepository')->willReturn($mockedCategoryRepository);
        //$articleRepository->setCategoryRepository($mockedCategoryRepository);
        
        $mockedAuthorRepository = $this->getMockBuilder(AuthorRepository::class)->disableOriginalConstructor()->getMock();
        $articleRepository->expects($this->any())->method('getAuthorRepository')->willReturn($mockedAuthorRepository);
        
        $mockedTagRepository = $this->getMockBuilder(TagRepository::class)->disableOriginalConstructor()->getMock();
        $articleRepository->expects($this->any())->method('getTagRepository')->willReturn($mockedTagRepository);
        //$articleRepository->setAuthorRepository($mockedAuthorRepository);
        
        $articleRepository->setPdo($this->getMockedPDO($manyArticles, $withCategory));

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
                ->getMockBuilder(stdClass::class)
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

}
