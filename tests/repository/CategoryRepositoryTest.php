<?php

declare(strict_types=1);

namespace App\Test\Repository;

use App\Model\Category;
use App\Repository\CategoryRepository;
use PDO;
use PDOStatement;
use PHPUnit\Framework\TestCase;
use stdClass;

class CategoryRepositoryTest extends TestCase {

    public function testGetCategoryById() {
        $mock = $this->getMockedCategoryRepository();
        $this->assertInstanceOf(Category::class, $mock->getCategoryById(999));
    }
    
    public function testGetCategories() {
        $mock = $this->getMockedCategoryRepository();
        $this->assertInstanceOf(Category::class, $mock->getCategories()[0]);
    }

    private function getMockedCategoryRepository(): CategoryRepository
    {
        
        return new CategoryRepository($this->getMockedPDO());
    }
    
    private function getMockedPDO() {
        $mockedReturn = new stdClass();
        $mockedReturn->id = 123;
        $mockedReturn->name = 'Test name';

        $mockedExecute = $this
                ->getMockBuilder(PDOStatement::class)
                ->getMock()
        ;
        $mockedExecute->method('execute')->willReturn(true);
        $mockedExecute->method('fetchObject')->will($this->onConsecutiveCalls($mockedReturn, false));
        //$mockedExecute->method('fetchObject')->will($this->returnValueMap($arrayWithMockedData));

        $mockedPDO = $this->getMockBuilder(PDO::class)
                ->disableOriginalConstructor()
                ->getMock()
        ;
        $mockedPDO
                ->method('prepare')
                ->willReturn($mockedExecute)
        ;

        return $mockedPDO;
    }

}
