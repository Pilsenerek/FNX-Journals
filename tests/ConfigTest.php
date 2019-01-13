<?php
declare(strict_types=1);

namespace App\Test;

use App\Config;
use PHPUnit\Framework\TestCase;

class ConfigTest extends TestCase
{

    public function testGetConfig() {
        $cfg = $this->getConfig()->getConfig();
        $this->assertObjectHasAttribute('db', $cfg);
        $this->assertObjectHasAttribute('username', $cfg->db);
    }

    private function getConfig(): Config {

        return new Config();
    }

}
