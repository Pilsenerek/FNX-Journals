<?php
declare(strict_types=1);

namespace App\Test\Model;

use App\Model\Author;
use PHPUnit\Framework\TestCase;

class AuthorTest extends TestCase
{

    public function testGetters(){
        $author = $this->getAuthor();
        $this->assertInstanceOf(Author::class, $author);
        $this->assertEquals(null, $author->getAbout());
        $author->setAbout('wefwef wefwefwf');
        $this->assertIsString($author->getAbout());
        $this->assertIsString($author->getFirstName());
        $this->assertIsString($author->getFullName());
        $this->assertIsInt($author->getId());
        $this->assertIsString($author->getLastName());
    }
    
    private function getAuthor(){
        $author = new Author();
        
        $author->setAbout(null);
        $author->setFirstName('wefewfwef');
        $author->setId(123456789);
        $author->setLastName('fewfwfwef wfwfwe');
        
        return $author;
    }
    

}
