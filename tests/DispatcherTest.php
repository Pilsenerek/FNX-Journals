<?php
declare(strict_types=1);

namespace App\Test;

use App\Dispatcher;
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
        $dispatcher = new Dispatcher();
       // $this->expectException(\Exception::class);
        Mockery::mock('overload:'.\App\Repository\ArticleRepository::class)->shouldReceive('getArticles')->once()->andReturn([]);
        Mockery::mock('overload:'.\App\Repository\AuthorRepository::class);
        Mockery::mock('overload:'. \App\Repository\CategoryRepository::class);
        Mockery::mock('overload:'. \App\Repository\TagRepository::class);
        $this->assertStringContainsString('<html>', $dispatcher->dispatch());
    }
    
    /**
    * @runInSeparateProcess
    * @preserveGlobalState disabled
    */  
    public function testDispatchBadAction() {
        $_REQUEST['c'] = 'index';
        $_REQUEST['a'] = 'testwefwe';
        $dispatcher = new Dispatcher();
        $this->expectException(\Exception::class);
        Mockery::mock('overload:'.\App\Repository\ArticleRepository::class);
        Mockery::mock('overload:'.\App\Repository\AuthorRepository::class);
        Mockery::mock('overload:'. \App\Repository\CategoryRepository::class);
        Mockery::mock('overload:'. \App\Repository\TagRepository::class);
        $dispatcher->dispatch();
    }   
    
    public function testDispatchBadAll(){
        $_REQUEST['c'] = 'weffffwfwff';
        $_REQUEST['a'] = 'testwefwe';
        $this->expectException(\Exception::class);
        $dispatcher = new Dispatcher();
        $dispatcher->dispatch();       
    }

    public function tearDown() {
        
        Mockery::close();
    }
}
