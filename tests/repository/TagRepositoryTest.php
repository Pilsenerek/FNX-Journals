<?php

declare(strict_types=1);

namespace App\Test\Repository;

use App\Repository\TagRepository;
use PHPUnit\Framework\TestCase;

class TagRepositoryTest extends TestCase {

    public function testGetTagsByArticleId() {
        $mock = $this->getMockedTagRepository();
        
        $this->assertInstanceOf(\App\Model\Tag::class, $mock->getTagsByArticleId(999)[0]);
    }
    
    public function testConstructorWithPdo(){
        $tagRepository = new TagRepository(new \PDO('sqlite::memory:'));
        $this->assertInstanceOf(TagRepository::class, $tagRepository);
    }

    private function getMockedTagRepository(){
        $mock = $this->getMockBuilder(TagRepository::class)->setMethods(null)->disableOriginalConstructor()->getMock();
        $mock->setPdo($this->getMockedPDO());

        return $mock;
    }
    
    private function getMockedPDO() {
        $mockedReturn = new \stdClass();
        $mockedReturn->id = 123;
        $mockedReturn->name = '8545 ergerge';

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
