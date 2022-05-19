<?php

declare(strict_types=1);

namespace App\Test\Repository;

use App\Repository\AuthorRepository;
use PHPUnit\Framework\TestCase;

class AuthorRepositoryTest extends TestCase {

    public function testGetAuthorsByArticleId() {
        $mock = $this->getMockedAuthorRepository(true);
        $this->assertInstanceOf(\App\Model\Author::class, $mock->getAuthorsByArticleId(999)[0]);
    }
    
    public function testGetAuthors() {
        $mock = $this->getMockedAuthorRepository(true);
        $this->assertInstanceOf(\App\Model\Author::class, $mock->getAuthors(999)[0]);
    }
    
    public function testGetAuthorById() {
        $mock = $this->getMockedAuthorRepository();
        $this->assertInstanceOf(\App\Model\Author::class, $mock->getAuthorById(999));
    }
    
    private function getMockedAuthorRepository($many = false){
        
        return new AuthorRepository($this->getMockedPDO($many));
    }

    private function getMockedPDO($many) {
        $mockedReturn = new \stdClass();
        $mockedReturn->id = 123;
        $mockedReturn->first_name = 'egehtrhegth';
        $mockedReturn->last_name = 'egehtrhegth';
        $mockedReturn->about = null;

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
        if ($many) {
            $mockedExecute
                    ->expects($this->at(2))->method('fetchObject')
                    ->willReturn(false)
            ;
        }

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
