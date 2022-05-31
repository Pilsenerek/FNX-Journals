<?php
declare(strict_types=1);

namespace App\Test;

use App\Application;
use App\Dispatcher;
use Mockery;
use PHPUnit\Framework\TestCase;

/**
 * @runTestsInSeparateProcesses
 */
class ApplicationTest extends TestCase
{

    public function setUp() : void {
        Mockery::mock('overload:' . Dispatcher::class)
                ->shouldReceive('dispatch')
                ->once()
                ->andReturn('<html>Some page</html>')
        ;
    }

    /**
     * @preserveGlobalState disabled
     */
    public function testRun() {
        $this->assertStringContainsString("<html>", $this->getApplication()->run());
        $this->assertStringContainsString("<html>", (string) $this->getApplication());
    }

    private function getApplication(): Application {
        $application = new Application();

        return $application;
    }

    public function tearDown() : void {
        Mockery::close();
    }

}
