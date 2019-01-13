<?php

declare(strict_types=1);

namespace App\Test\Controller;

use App\Controller\IndexController;
use App\Model\Article;
use App\Repository\ArticleRepository;
use PDOException;
use PHPUnit\Framework\TestCase;

class IndexControllerTest extends TestCase {

    public function testIndexAction() {
        $mock = $this->getMockedIndexController();
        $this->assertIsArray($mock->indexAction());
        
        $_REQUEST['category_id'] = 999;
        $mock = $this->getMockedIndexController();
        $this->assertIsArray($mock->indexAction());
        
        $this->noDbAction();
    }

    public function testArticleAction() {
        $_REQUEST['id'] = 999;
        $mock = $this->getMockedIndexController();
        $this->assertIsArray($mock->articleAction());
        $this->noDbAction();
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

    private function getMockedIndexController() {
        $mockedArticleRepository = $this->getMockBuilder(ArticleRepository::class)->disableOriginalConstructor()->getMock();
        $mockedArticle = $this->createMock(Article::class);
        $mockedArticleRepository->expects($this->any())->method('getArticles')->willReturn([$mockedArticle]);
        $mockedArticleRepository->expects($this->any())->method('getArticleById')->willReturn($mockedArticle);

        $mock = $this->getMockBuilder(IndexController::class)->setMethods(['getArticleRepository'])->getMock();
        
        $mock->expects($this->any())
                ->method('getArticleRepository')
                ->willReturn($mockedArticleRepository);

        return $mock;
    }

}
