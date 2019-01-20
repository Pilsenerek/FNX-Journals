<?php

declare(strict_types=1);

namespace App;

use stdClass;

/**
 * @todo implement yaml and add config object into app context
 * 
 * @author Michal Zbieranek
 */
class Config {

    /** @var [] */
    private $config = [
        'db' => [
            'dsn' => 'mysql:host=127.0.0.1;port=3306;dbname=fnx_journals',
            'username' => 'root',
            'password' => '',
        ],
        'firewall' => [
            'loginUrl' => '?a=login',
            //these controllers & actions are before firewall, rest of all are behind
            //when there are no actions all of them are before firewall
            'anonymous' => [
                'IndexController' => [
                    'loginAction',
                ],
            ],
        ],
    ];

    /**
     * @return stdClass
     */
    public function getConfig(): stdClass {

        $cfg = json_decode(json_encode($this->config), false);

        return $cfg;
    }

}
