<?php
declare(strict_types=1);

namespace App\Test;

use App\Auth;
use App\Dispatcher;
use App\Repository\ArticleRepository;
use App\Repository\AuthorRepository;
use App\Repository\CategoryRepository;
use App\Repository\TagRepository;
use App\Repository\UserRepository;
use App\View;
use Exception;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * @todo refactor this and find the best way to mock class_exists function
 */
class DispatcherTest extends TestCase
{

    /**
    * @runInSeparateProcess
    * @preserveGlobalState disabled
    */  
    public function testDispatch() {
        //default page
        Mockery::mock('overload:'. Auth::class)->shouldReceive('firewall')->once()->andReturn(null);
        Mockery::mock('overload:'. View::class)->shouldReceive('render')->once()->andReturn('<html>wefwefwefwf</html>');
        $dispatcher = new Dispatcher();
        Mockery::mock('overload:'.ArticleRepository::class)->shouldReceive('getArticles')->once()->andReturn([]);
        Mockery::mock('overload:'.AuthorRepository::class);
        Mockery::mock('overload:'. CategoryRepository::class);
        Mockery::mock('overload:'. TagRepository::class);
        Mockery::mock('overload:' . UserRepository::class);
        $this->assertStringContainsString('<html>', $dispatcher->dispatch());
    }
    
    /**
    * @runInSeparateProcess
    * @preserveGlobalState disabled
    */  
    public function testDispatchBadAction() {
        $_REQUEST['c'] = 'index';
        $_REQUEST['a'] = 'testwefwe';
        Mockery::mock('overload:'. Auth::class);
        $dispatcher = new Dispatcher();
        $this->expectException(Exception::class);
        Mockery::mock('overload:'.ArticleRepository::class);
        Mockery::mock('overload:'.AuthorRepository::class);
        Mockery::mock('overload:'. CategoryRepository::class);
        Mockery::mock('overload:'. TagRepository::class);
        Mockery::mock('overload:' . UserRepository::class);
        $dispatcher->dispatch();
    }   

    /**
    * @runInSeparateProcess
    * @preserveGlobalState disabled
    */      
    public function testDispatchBadAll(){
        $_REQUEST['c'] = 'weffffwfwff';
        $_REQUEST['a'] = 'testwefwe';
        $this->expectException(Exception::class);
        Mockery::mock('overload:'. Auth::class);
        $dispatcher = new Dispatcher();
        $dispatcher->dispatch();       
    }
    
}
