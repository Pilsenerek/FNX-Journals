<?php
declare(strict_types=1);

namespace App\Test\Model;

use App\Model\Tag;
use PHPUnit\Framework\TestCase;

class TagTest extends TestCase
{

    public function testGetters(){
        $tag = $this->getTag();
        $this->assertInstanceOf(Tag::class, $tag);
        $this->assertIsString($tag->getName());
        $this->assertIsInt($tag->getId());
        $tag->setNumberOfArticles(999);
        $this->assertIsInt($tag->getNumberOfArticles());
    }
    
    private function getTag(){
        $tag = new Tag();
        
        $tag->setId(123456789);
        $tag->setName('wefwe wewef');
        
        return $tag;
    }
    

}
