<?php

declare(strict_types=1);

namespace App;

use PDO;
use stdClass;

/**
 * @todo implement simple query builder
 * @todo implement dynamic joining like getArticle($with = [Tag::class, Category::class])
 * 
 * @author Michal Zbieranek
 */
abstract class RepositoryAbstract {

    /** @var PDO */
    protected $pdo;

    public function __construct(PDO $pdo = null) {
        $config = new Config();
        $dbCfg = $config->getConfig()->db;
        if ($pdo) {
            $this->pdo = $pdo;
        } else {
            $this->pdo = new PDO($dbCfg->dsn, $dbCfg->username, $dbCfg->password);
        }
    }

}
