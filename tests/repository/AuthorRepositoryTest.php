<?php

declare(strict_types=1);

namespace App\Test\Repository;

use App\Repository\AuthorRepository;
use PHPUnit\Framework\TestCase;

class AuthorRepositoryTest extends TestCase {

    public function testGetAuthorsByArticleId() {
        $mock = $this->getMockedAuthorRepository();
        $this->assertInstanceOf(\App\Model\Author::class, $mock->getAuthorsByArticleId(999)[0]);
    }

    public function testConstructorWithPdo(){
        $authorRepository = new AuthorRepository(new \PDO('sqlite::memory:'));
        $this->assertInstanceOf(AuthorRepository::class, $authorRepository);
    }
    
    private function getMockedAuthorRepository(){
        $mock = $this->getMockBuilder(AuthorRepository::class)->setMethods(null)->disableOriginalConstructor()->getMock();
        $mock->setPdo($this->getMockedPDO());

        return $mock;
    }

    private function getMockedPDO() {
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
        $mockedExecute
                ->expects($this->at(2))->method('fetchObject')
                ->willReturn(false)
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
