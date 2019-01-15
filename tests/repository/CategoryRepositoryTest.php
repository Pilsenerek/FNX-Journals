<?php

declare(strict_types=1);

namespace App\Test\Repository;

use App\Repository\CategoryRepository;
use PHPUnit\Framework\TestCase;

class CategoryRepositoryTest extends TestCase {

    public function testGetCategoryById() {
        $mock = $this->getMockedCategryRepository();
        $this->assertInstanceOf(\App\Model\Category::class, $mock->getCategoryById(999));
    }
    
    public function testGetCategories() {
        $mock = $this->getMockedCategryRepository();
        $this->assertInstanceOf(\App\Model\Category::class, $mock->getCategories()[0]);
    }

    private function getMockedCategryRepository(){
        
        return new CategoryRepository($this->getMockedPDO());
    }
    
    private function getMockedPDO() {
        $mockedReturn = new \stdClass();
        $mockedReturn->id = 123;
        $mockedReturn->name = 'egehtrhegth';

        $mockedExecute = $this
                ->getMockBuilder(\stdClass::class)
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

        $mockedPDO = $this->getMockBuilder(\PDO::class)
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
