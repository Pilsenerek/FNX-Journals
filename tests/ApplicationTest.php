<?php
declare(strict_types=1);

namespace App\Test;

use App\Application;
use App\Dispatcher;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{

    /**
     * @runInSeparateProcess
     */
    public function testRun() {
        \Mockery::mock('overload:'.Dispatcher::class)->shouldReceive('dispatch')->once()->andReturn('<html>Some page</html>');
        $this->assertStringContainsString("<html>", $this->getApplication()->run());
        $this->assertStringContainsString("<html>", (string)$this->getApplication());
    }

    private function getApplication(): Application {
        $application = new Application();
        
        return $application;
    }

}
