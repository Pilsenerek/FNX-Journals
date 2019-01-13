<?php
declare(strict_types=1);

namespace App\Test\Model;

use App\Model\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testGetters(){
        $user = $this->getUser();
        $this->assertInstanceOf(User::class, $user);
        $this->assertIsString($user->getUsername());
        $this->assertIsString($user->getPassword());
        $this->assertIsInt($user->getId());
        $this->assertIsFloat($user->getWallet());
        $user->setWallet();
        $this->assertEquals(0, $user->getWallet());
    }
    
    private function getUser(){
        $user = new User();
        
        $user->setId(123456789);
        $user->setUsername('wefwe wewef');
        $user->setPassword('fererg wefwe wewef');
        $user->setWallet(123.45);
        
        return $user;
    }
    

}
