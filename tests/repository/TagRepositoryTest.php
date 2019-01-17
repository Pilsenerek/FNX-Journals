<?php

declare(strict_types=1);

namespace App\Test\Repository;

use App\Model\Tag;
use App\Repository\TagRepository;
use App\RepositoryAbstract;
use PDO;
use PDOException;
use PHPUnit\Framework\TestCase;
use stdClass;

class TagRepositoryTest extends TestCase {

    /**
     * @runInSeparateProcess
     */
    public function testGetTagsByArticleId() {
        $mock = $this->getMockedTagRepository();
        
        $this->assertInstanceOf(Tag::class, $mock->getTagsByArticleId(999)[0]);
    }
    
    /**
     * @runInSeparateProcess
     */
    public function testGetTagsOrderByPopularity() {
        $mock = $this->getMockedTagRepository();
        
        $this->assertInstanceOf(Tag::class, $mock->getTagsOrderByPopularity(999)[0]);
    }

    /**
     * @runInSeparateProcess
     */
    public function testNoDBConnection() {
        try {
            $this->assertInstanceOf(RepositoryAbstract::class, new TagRepository());
        } catch (PDOException $exc) {
            $this->expectException(PDOException::class);
            $this->assertInstanceOf(RepositoryAbstract::class, new TagRepository());
        }
    }

    private function getMockedTagRepository(){
        
        return new TagRepository($this->getMockedPDO());
    }
    
    private function getMockedPDO() {
        $mockedReturn = new stdClass();
        $mockedReturn->id = 123;
        $mockedReturn->name = '8545 ergerge';
        $mockedReturn->number_of_articles = 999;

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
        $mockedExecute
                ->expects($this->at(2))->method('fetchObject')
                ->willReturn(false)
        ;

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
