<?php

declare(strict_types=1);

namespace App\Test\Repository;

use App\Model\User;
use App\Repository\ArticleRepository;
use App\Repository\UserRepository;
use Mockery;
use PDO;
use PHPUnit\Framework\TestCase;
use stdClass;

class UserRepositoryTest extends TestCase {

    public function setUp() {
        Mockery::mock('overload:' . ArticleRepository::class)
                ->shouldReceive('getArticles')
                ->once()
                ->andReturn([$this->createMock(\App\Model\Article::class)])
        ;
    }

    /**
     * @runInSeparateProcess
     */  
    public function testGetUserAuth() {
        $mock = $this->getMockedUserRepository(false, false);
        $this->assertInstanceOf(User::class, $mock->getUserAuth('wefwefwef', 'wefwewefw'));
        
        $mock = $this->getMockedUserRepository(false, true);
        $this->assertNull($mock->getUserAuth('wefwefwef', 'wefwewefw'));
    }
    
    /**
     * @runInSeparateProcess
     */  
    public function testGetUserById() {
        $mock = $this->getMockedUserRepository();
        
        $this->assertInstanceOf(User::class, $mock->getUserById(12345));
    }
    
    /**
     * @runInSeparateProcess
     */  
    public function testBuyArticle() {
        $art = new \App\Model\Article();
        $art->setId(1234);
        $art->setPrice(45);
        $user = new User();
        $user->setId(5678);
        $user->setWallet(10, 56);

        $mock = $this->getMockedUserRepository(true, false, true, true);
        $this->assertTrue($mock->buyArticle($art, $user));

        $mock = $this->getMockedUserRepository(true, false, false, true);
        $this->assertFalse($mock->buyArticle($art, $user));

        $mock = $this->getMockedUserRepository(true, false, true, false);
        $this->assertFalse($mock->buyArticle($art, $user));
    }

    private function getMockedUserRepository($buyArticle = false, $returnNull = false, $firstTrue = true, $secondTrue = true) {
        if ($buyArticle) {
            return new UserRepository($this->getMockedPDOBuy($firstTrue, $secondTrue));
        } else {

            return new UserRepository($this->getMockedPDO($returnNull));
        }
    }

    private function getMockedReturn($isNull = false) {
        if ($isNull) {
            $mockedReturn = null;
        } else {
            $mockedReturn = new stdClass();
            $mockedReturn->id = 123;
            $mockedReturn->username = '8545 ergerge';
            $mockedReturn->password = '8545 ergerge';
            $mockedReturn->wallet = 999.99;
        }

        return $mockedReturn;
    }

    private function getMockedPDO($returnNull = false) {
        $mockedReturn = $this->getMockedReturn($returnNull);

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
                ->expects($this->any())->method('fetchObject')
                ->willReturn($mockedReturn)
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

    private function getMockedPDOBuy($firstTrue = true, $secondTrue = true) {
        $mockedExecute = $this
                ->getMockBuilder(stdClass::class)
                ->setMethods(['execute'])
                ->getMock()
        ;
        
        $mockedExecute
                ->expects($this->any())->method('execute')
                ->willReturn($firstTrue)
        ;
        
        $mockedExecute2 = $this
                ->getMockBuilder(stdClass::class)
                ->setMethods(['execute'])
                ->getMock()
        ;
        $mockedExecute2
                ->expects($this->any())->method('execute')
                ->willReturn($secondTrue)
        ;
        
        $mockedPDO = $this->getMockBuilder(PDO::class)
                ->disableOriginalConstructor()
                ->setMethods(['prepare', 'beginTransaction', 'commit'])
                ->getMock()
        ;
        $mockedPDO
                ->expects($this->at(1))
                ->method('prepare')
                ->willReturn($mockedExecute)
        ;
        
        if ($firstTrue) {
            $mockedPDO
                    ->expects($this->at(2))
                    ->method('prepare')
                    ->willReturn($mockedExecute2)
            ;
        }

        $mockedPDO
                ->expects($this->any())->method('beginTransaction')
                ->willReturn(true)
        ;
        $mockedPDO
                ->expects($this->any())->method('commit')
                ->willReturn(true)
        ;

        return $mockedPDO;
    }
}
