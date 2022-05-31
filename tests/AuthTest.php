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

/**
 * @runTestsInSeparateProcesses
 */
class AuthTest extends TestCase
{

    private $userRepository;
    
    public function setUp() : void {
        $this->userRepository = Mockery::mock('overload:'. UserRepository::class);
    }

    public function testFireWall() {
         $this->userRepository->shouldReceive('getUserAuth')->times()->andReturn(new User());
         
        //sth before firewall
        $_REQUEST['a'] = 'login';
        $this->mockCfg();
        $auth = new Auth();
        $this->assertNull($auth->firewall('IndexController', 'loginAction'));
        
        //sth behind firewall
        $_REQUEST['a'] = 'login';
        $auth = new Auth();
        $this->assertNull($auth->firewall('IndexController', 'tagsAction'));
    }

    public function testGetUser(){
        $this->userRepository->shouldReceive('getUser')->times()->andReturn(null);
        $this->mockCfg();
        $auth = new Auth();
        $this->assertNull($auth->getUser());
    }
    
    public function testAuthenticate(){
        $this->userRepository->shouldReceive('getUserAuth')->times()->andReturn(new User());
        $this->mockCfg();
        $auth = new Auth();
        $this->assertInstanceOf(User::class, $auth->authenticate('wefewfewf', 'wefwefwe'));
    }
    
    public function testAuthenticateFail(){
        $this->userRepository->shouldReceive('getUserAuth')->times()->andReturn(null);
        $this->mockCfg();
        $auth = new Auth();
        $this->assertNull($auth->authenticate('wefewfewf', 'wefwefwe'));
    }
    
    public function testLogout(){
        $this->mockCfg();
        $auth = new Auth();
        $_SESSION = [];
        $this->assertTrue($auth->logout());
    }
    
    public function testRefresh(){
        $user = $this->createMock(User::class);
        $_SESSION['user'] = $user;
        $this->userRepository->shouldReceive('getUserById')->times()->andReturn($user);
        $this->mockCfg();
        $auth = new Auth();
        $this->assertInstanceOf(User::class, $auth->refresh());
    }
    
    public function testRefreshFail(){
        $_SESSION['user'] = null;
        $this->userRepository->shouldReceive('getUserById')->times()->andReturn('dupa');
        $this->mockCfg();
        $auth = new Auth();
        $this->assertNull($auth->refresh());
    }
    
    public function testFireWallAllActions() {
        $this->mockCfg(false);
        
        $auth = new Auth();
        $this->assertNull($auth->firewall('IndexController', 'qwerty1234Action'));
    }
    
    private function mockCfg($withLoginAction = true) {
        $mCfg = Mockery::mock('overload:' . Config::class);
        $cfg = new stdClass();
        $cfg->firewall = new stdClass();
        $cfg->firewall->loginUrl = '?wfwefwf=wfwfwe';
        $cfg->firewall->anonymous = new stdClass();
        if ($withLoginAction) {
            $cfg->firewall->anonymous->IndexController = ['loginAction'];
        } else {
            $cfg->firewall->anonymous->IndexController = [];
        }

        $mCfg->shouldReceive('getConfig')->times()->andReturn($cfg);
        
        return $mCfg;
    }

    protected function tearDown() : void {
        Mockery::close();
    }

}
