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

    /**
     * @return string
     */
    public function run(): string {

        return $this->dispatcher->dispatch();
    }

    /**
     * @param \App\Dispatcher $dispatcher
     * @return \App\Application
     */
    public function setDispatcher(Dispatcher $dispatcher): Application {
        $this->dispatcher = $dispatcher;

        return $this;
    }

    public function __toString(): string {

        return $this->run();
    }

}
