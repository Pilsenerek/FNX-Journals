<?php
declare(strict_types=1);

namespace App\Test;

use App\Auth;
use App\View;
use Mockery;
use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{

    public function setUp() {
        $mockedAuth = Mockery::mock('overload:' . Auth::class);
        $mockedAuth->shouldReceive('getUser')->times()->andReturn(null);
    }
    
     /**
     * @runInSeparateProcess
     */
    public function testRender() {
        
        $render = $this->getView()->render('IndexController', 'IndexAction', ['articles' => []]);
        
        $this->assertStringContainsString("<html>", $render);
    }

    private function getView(): View {

        return new View();
    }
    
    public function tearDown() {
        Mockery::close();
    }

}
