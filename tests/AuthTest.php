<?php
declare(strict_types=1);

namespace App\Test;

use App\Auth;
use App\Config;
use App\Model\User;
use App\Repository\UserRepository;
use Mockery;
use PHPUnit\Framework\TestCase;
use stdClass;

class AuthTest extends TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testFireWall() {
         Mockery::mock('overload:'. UserRepository::class)->shouldReceive('getUserAuth')->once()->andReturn(new User());
         
        //sth before firewall
        $_REQUEST['a'] = 'login';
        $auth = new Auth();
        $this->assertNull($auth->firewall('IndexController', 'loginAction'));
        
        //sth behind firewall
        $_REQUEST['a'] = 'login';
        $auth = new Auth();
        $this->assertNull($auth->firewall('IndexController', 'tagsAction'));
    }

    /**
     * @runInSeparateProcess
     */    
    public function testGetUser(){
        Mockery::mock('overload:'. UserRepository::class)->shouldReceive('getUser')->once()->andReturn(null);
        $auth = new Auth();
        $this->assertNull($auth->getUser());
    }
    
    /**
     * @runInSeparateProcess
     */    
    public function testAuthenticate(){
        Mockery::mock('overload:'. UserRepository::class)->shouldReceive('getUserAuth')->once()->andReturn(new User());
        $auth = new Auth();
        $this->assertInstanceOf(User::class, $auth->authenticate('wefewfewf', 'wefwefwe'));
    }
    
    /**
     * @runInSeparateProcess
     */    
    public function testAuthenticateFail(){
        Mockery::mock('overload:'. UserRepository::class)->shouldReceive('getUserAuth')->once()->andReturn(null);
        $auth = new Auth();
        $this->assertNull($auth->authenticate('wefewfewf', 'wefwefwe'));
    }
    
    /**
     * @runInSeparateProcess
     */    
    public function testLogout(){
        Mockery::mock('overload:'. UserRepository::class);
        $auth = new Auth();
        $_SESSION = [];
        $this->assertTrue($auth->logout());
    }
    
    
    /**
     * @runInSeparateProcess
     */
    public function testFireWallAllActions() {
        $cfg = new stdClass();
        $cfg->firewall = new stdClass();
        $cfg->firewall->anonymous = new stdClass();
        $cfg->firewall->anonymous->IndexController = [];
        Mockery::mock('overload:'. Config::class)->shouldReceive('getConfig')->once()->andReturn($cfg);
        Mockery::mock('overload:'. UserRepository::class);
        
        $auth = new Auth();
        $this->assertNull($auth->firewall('IndexController', 'qwerty1234Action'));
    }

}
