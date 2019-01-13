<?php

declare(strict_types=1);

namespace App;

/**
 * @todo implement twig (or any other template engine)
 * 
 * @author Michal Zbieranek
 */
class View {

    /**
     * Forward variables into templates and shows it
     * 
     * @param array $data
     * @return string
     */
    public function render(string $controller, string $action, array $data = []): string {
        ob_start();
        $_content = $this->renderTemplate($controller, $action, $data);
        include 'template' . DIRECTORY_SEPARATOR . 'layout.html.php';

        return ob_get_clean();
    }

    /**
     * @param string $controller
     * @param string $action
     * @param array $data
     * @return string
     */
    private function renderTemplate(string $controller, string $action, array $data = []): string {
        $folder = lcfirst(str_replace('Controller', '', $controller));
        $template = lcfirst(str_replace('Action', '.html.php', $action));
        $path = $folder . DIRECTORY_SEPARATOR . $template;
        ob_start();
        extract($data);
        include 'template' . DIRECTORY_SEPARATOR . $path;

        return ob_get_clean();
    }

}
