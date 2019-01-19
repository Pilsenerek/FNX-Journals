<?php

declare(strict_types=1);

namespace App\Repository;

use App\Model\Article;
use App\Model\User;
use App\RepositoryAbstract;
use PDO;
use stdClass;

/**
 * @author Michal Zbieranek
 */
class UserRepository extends RepositoryAbstract {


    /** @var ArticleRepository */
    private $articleRepository;
    
    public function __construct(PDO $pdo = null) {
        parent::__construct($pdo);
        
        $this->articleRepository = new ArticleRepository();
    }

    /**
     * @param string $username
     * @param string $password
     * @return User|null
     */
    public function getUserAuth(string $username, string $password): ?User {
        $query = $this->pdo->prepare(
                "select * from user where username=? and password=?"
        );
        $query->execute([$username, $password]);
        $result = $query->fetchObject();
        if ($result) {

            return $this->createUserModel($result);
        } else {
            return null;
        }
    }
    
    /**
     * @param int $id
     * @return User
     */
    public function getUserById(int $id): User {
        $query = $this->pdo->prepare("select * from user where id=?");
        $query->execute([$id]);
        $user = $this->createUserModel($query->fetchObject());

        return $user;
    }

    /**
     * @param Article $article
     * @param User $user
     * @return bool
     */
    public function buyArticle(Article $article, User $user) : bool {
        $this->pdo->beginTransaction();
        $newWallet = $user->getWallet() - $article->getPrice();
        $queryUser = $this->pdo->prepare("update user set wallet=? where id=?");
        if (!$queryUser->execute([$newWallet, $user->getId()])) {

            return false;
        }
        $queryArt = $this->pdo->prepare("insert into article_has_user (user_id, article_id) values(?,?)");
        if (!$queryArt->execute([$user->getId(), $article->getId()])) {

            return false;
        }

        return $this->pdo->commit();
    }

    /**
     * @param stdClass $stdClass
     * @return User
     */
    private function createUserModel(stdClass $stdClass) {
        $user = new User();
        $user->setId((int) $stdClass->id);
        $user->setUsername($stdClass->username);
        $user->setPassword($stdClass->password);
        $user->setWallet((float) $stdClass->wallet);
        $user->setArticles($this->fetchArticles((int) $stdClass->id));

        return $user;
    }
    
    /**
     * @param int $userId
     * @return array
     */
    private function fetchArticles(int $userId) : array{
     
        return $this->articleRepository->getArticles(['user_id' => $userId]);
    }

}
