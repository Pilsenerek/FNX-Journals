<?php
declare(strict_types=1);

namespace App\Test\Model;

use App\Model\Category;
use PHPUnit\Framework\TestCase;

class CategoryTest extends TestCase
{

    public function testGetters(){
        $category = $this->getCategory();
        $this->assertInstanceOf(Category::class, $category);
        $this->assertIsString($category->getName());
        $this->assertIsInt($category->getId());
    }
    
    private function getCategory(){
        $category = new Category();
        
        $category->setId(123456789);
        $category->setName('wefwe wefwefwef');
        
        return $category;
    }
    

}
