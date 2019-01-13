<?php
declare(strict_types=1);

namespace App\Test;

use App\Dispatcher;
use PHPUnit\Framework\TestCase;

class DispatcherTest extends TestCase
{

    public function testDispatch() {
        $this->assertStringContainsString('<html>', $this->getDispatcher()->dispatch());

        $_REQUEST['c'] = 'index';
        $_REQUEST['a'] = 'testwefwe';
        $this->expectException(\Exception::class);
        $dispatcher = new Dispatcher();
        $dispatcher->dispatch();


        $_REQUEST['c'] = 'weffffwfwff';
        $_REQUEST['a'] = 'testwefwe';
        $this->expectException(\Exception::class);
        $dispatcher = new Dispatcher();
        $dispatcher->dispatch();        
    }   
    
    public function testDispatchBadAll(){
        $_REQUEST['c'] = 'weffffwfwff';
        $_REQUEST['a'] = 'testwefwe';
        $this->expectException(\Exception::class);
        $dispatcher = new Dispatcher();
        $dispatcher->dispatch();       
    }

    private function getDispatcher(): object {
        $created = $this->createMock(\App\Controller\IndexController::class);
        $created->expects($this->any())->method('indexAction')->willReturn(['articles' => []]);
        $creator = $this->getMockBuilder(Dispatcher::class)->setMethods(['getControllerInstance'])->getMock();
        $creator->expects($this->any())
                ->method('getControllerInstance')
                ->willReturn($created)
        ;
        
        return $creator;
    }

}
