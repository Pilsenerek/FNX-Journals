<?php

declare(strict_types=1);

namespace App;

/**
 * @todo implement error handler/logger/debugger
 * @todo implement dependency container
 * 
 * @author Michal Zbieranek
 */
class Application {

    /** @var Dispatcher */
    private $dispatcher;

    public function __construct() {
        $this->dispatcher = new Dispatcher();
    }

    private function boot(): void {
        //@todo find better way to mock this function
        @session_start();
    }

    /**
     * @return string
     */
    public function run(): ?string {
        $this->boot();

        return $this->dispatcher->dispatch();
    }

    public function __toString(): string {

        return $this->run();
    }

}
