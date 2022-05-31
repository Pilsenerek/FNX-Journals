<?php
declare(strict_types=1);

namespace App\Test;

use App\Auth;
use App\View;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class ViewTest extends TestCase
{

    public function setUp() : void {
        $mockedAuth = Mockery::mock('overload:' . Auth::class);
        $mockedAuth->shouldReceive('getUser')->times()->andReturn(null);
    }

    /**
     * @preserveGlobalState disabled
     */
    public function testRender() {
        
        $render = $this->getView()->render('IndexController', 'IndexAction', ['articles' => []]);
        
        $this->assertStringContainsString("<html>", $render);
    }

    private function getView(): View {

        return new View();
    }
    
    public function tearDown() : void {
        Mockery::close();
    }

}
