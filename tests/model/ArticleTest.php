<?php
declare(strict_types=1);

namespace App\Test\Model;

use App\Model\Article;
use App\Model\Category;
use PHPUnit\Framework\TestCase;

class ArticleTest extends TestCase
{

    public function testGetters(){
        $article = $this->getArticle();
        $this->assertInstanceOf(Article::class, $article);
        $this->assertIsArray($article->getAuthors());
        $this->assertInstanceOf(Category::class ,$article->getCategory());
        $this->assertIsString($article->getContent());
        $this->assertIsInt($article->getId());
        $this->assertIsFloat($article->getPrice());
        $this->assertIsString($article->getShortDescription());
        $this->assertIsArray($article->getTags());
        $this->assertIsString($article->getTitle());
        $this->assertIsArray($article->getUsers());
        $this->assertFalse($article->isFree());
        $article->setPrice(0);
        $this->assertTrue($article->isFree());
    }
    
    private function getArticle(){
        $article = new Article();
        
        $article->setAuthors([]);
        $article->setCategory($this->createMock(Category::class));
        $article->setContent('wefwef wefewf wefwe');
        $article->setId(123456789);
        $article->setPrice(99.999);
        $article->setShortDescription('fewfwfwef wfwfwe');
        $article->setTags([]);
        $article->setTitle('wefwefwe wefwefwef');
        $article->setUsers([]);
        
        return $article;
    }
    

}
