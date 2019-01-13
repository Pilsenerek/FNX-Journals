<?php
declare(strict_types=1);

namespace App\Test;

use App\Application;
use App\Dispatcher;
use PHPUnit\Framework\TestCase;

class ApplicationTest extends TestCase
{

    public function testRun() {
        $this->assertStringContainsString("<html>", $this->getApplication()->run());
        $this->assertStringContainsString("<html>", (string)$this->getApplication());
    }

    private function getApplication(): Application {
        $application = new Application();
        $dispatcher = $this->createMock(Dispatcher::class);
        $dispatcher->expects($this->any())->method('dispatch')->willReturn('<html>Some page</html>');
        $application->setDispatcher($dispatcher);
        
        return $application;
    }

}
