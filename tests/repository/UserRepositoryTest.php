<?php

declare(strict_types=1);

namespace App\Test\Repository;

use App\Model\User;
use App\Repository\UserRepository;
use PDO;
use PHPUnit\Framework\TestCase;
use stdClass;

class UserRepositoryTest extends TestCase {

    public function testGetUserAuth() {
        $mock = $this->getMockedUserRepository();
        
        $this->assertInstanceOf(User::class, $mock->getUserAuth('wefwefwef', 'wefwewefw'));
        $this->assertNull($mock->getUserAuth('wefwefwef', 'wefwewefw'));
    }

    private function getMockedUserRepository(){
        
        return new UserRepository($this->getMockedPDO());
    }
    
    private function getMockedPDO() {
        $mockedReturn = new stdClass();
        $mockedReturn->id = 123;
        $mockedReturn->username = '8545 ergerge';
        $mockedReturn->password = '8545 ergerge';
        $mockedReturn->wallet = 999.99;

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
                ->willReturn(null)
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
