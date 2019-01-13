<?php
declare(strict_types=1);

namespace App\Test;

use App\View;
use PHPUnit\Framework\TestCase;

class ViewTest extends TestCase
{

    public function testRender() {
        $render = $this->getView()->render('IndexController', 'IndexAction', ['articles' => []]);
        
        $this->assertStringContainsString("<html>", $render);
    }

    private function getView(): View {

        return new View();
    }

}
