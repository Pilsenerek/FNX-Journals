<?php
declare(strict_types=1);

namespace App;

use App\Model\User;
use App\Repository\UserRepository;
use stdClass;

/**
 * @todo move firewall into separate class
 * @todo implement wrapper for $_SESSION
 * 
 * @author Michal Zbieranek
 */
class Auth {
    
    /** stdClass */
    private $config;
    
    /** UserRepository */
    private $userRepository;

    public function __construct() {
        $config = new Config();
        $this->config = $config->getConfig()->firewall;
        $this->userRepository = new UserRepository();
    }

    /**
     * @param string $controllerName
     * @param string $actionName
     * @return void
     */
    public function firewall(string $controllerName, string $actionName) : void {
        if (
                $this->isBehindFirewall($controllerName, $actionName) &&
                empty($_SESSION['user'])
        ) {
            header('Location: ' . $this->config->loginUrl);
        }
    }
    
    /**
     * @param string $username
     * @param string $password
     * @return User|null
     */
    public function authenticate(string $username, string $password): ?User {
        $user = $this->userRepository->getUserAuth($username, $password);
        if ($user) {
            $_SESSION['user'] = $user;
        }

        return $user;
    }

    /**
     * @return bool
     */
    public function logout() : bool {
        //@todo fidn better way to mock session functions
        @session_destroy();
        @session_unset();
        unset($_SESSION['user']);
        $_SESSION = array();
        
        return true;
    }
    
    /**
     * @return User|null
     */
    public function getUser() : ?User{
        
        return $_SESSION['user'] ?? null;
    }
    
    /**
     * @param string $controllerName
     * @param string $actionName
     * @return boolean
     */
    private function isBehindFirewall(string $controllerName, string $actionName) {
        if (property_exists($this->config->anonymous, $controllerName)) {
            $allowedController = $this->config->anonymous->$controllerName;
            if (empty($allowedController)) {

                return false;
            } else {
                if (in_array($actionName, $allowedController)) {

                    return false;
                }
            }
        }

        return true;
    }

}
