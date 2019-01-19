<?php
declare(strict_types=1);

namespace App\Test\Model;

use App\Model\Article;
use App\Model\User;
use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{

    public function testGetters(){
        $user = $this->getUser();
        $this->assertInstanceOf(User::class, $user);
        $this->assertIsString($user->getUsername());
        $this->assertIsString($user->getPassword());
        $this->assertIsInt($user->getId());
        $this->assertIsFloat($user->getWallet());
        $user->setWallet();
        $this->assertEquals(0, $user->getWallet());
        $this->assertIsArray($user->getArticles());
    }
    
    private function getUser(){
        $user = new User();
        
        $article = new Article();
        $article->setId(123);
        $article->setPrice(12345);

        $article2 = new Article();
        $article2->setId(124);
        $article2->setPrice(0);
        
        $user->setId(123456789);
        $user->setUsername('wefwe wewef');
        $user->setPassword('fererg wefwe wewef');
        $user->setWallet(123.45);
        $user->setArticles([$article]);
        $user->addArticle($article2);
        $user->canAfford($article);
        $user->canAfford($article2);
        
        return $user;
    }
    

}
