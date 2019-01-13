<?php
declare(strict_types=1);

namespace App;

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
    ];

    /**
     * @return \stdClass
     */
    public function getConfig(): \stdClass {

        $cfg = json_decode(json_encode($this->config), false);

        return $cfg;
    }

}
