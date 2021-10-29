<?php

declare(strict_types=1);

namespace App;

use Exception;

/**
 * @todo implement router
 * @todo implement wrapper for $_REQUEST
 * 
 * @author Michal Zbieranek
 */
class Dispatcher {

    /** @var array */
    private $request = [];

    /** @var string */
    private $defaultController = 'IndexController';

    /** @var string */
    private $defaultAction = 'indexAction';

    /** @var View */
    private $view;

    /** Auth */
    private $auth;

    /**
     * @param stdClass $config
     */
    public function __construct() {
        $this->request = $_REQUEST;
        $this->view = new View();
        $this->auth = new Auth();
    }

    /**
     * Call proper controller::action
     * 
     * @return string
     */
    public function dispatch(): ?string {
        $controller = $this->getControllerInstance();
        $action = $this->getActionName();
        if (method_exists($controller, $action)) {
            $this->auth->firewall($this->getControllerName(), $this->getActionName());
            if (is_null($controller->$action())) {

                return null;
            }

            return $this->view->render($this->getControllerName(), $action, $controller->$action());
        } else {

            throw new Exception('Bad action name');
        }
    }

    /**
     * @return object
     */
    private function getControllerInstance(): object {
        $controllerClass = 'App\\Controller\\' . $this->getControllerName();
        if (class_exists($controllerClass)) {

            return new $controllerClass();
        } else {

            throw new Exception('Bad controller name');
        }
    }

    /**
     * @return string
     */
    public function getControllerName(): string {
        if (empty($this->request['c'])) {

            return $this->defaultController;
        } else {

            return ucfirst($this->request['c']) . 'Controller';
        }
    }

    /**
     * @return string
     */
    public function getActionName(): string {
        if (empty($this->request['a'])) {

            return $this->defaultAction;
        } else {

            return $this->request['a'] . 'Action';
        }
    }

}
