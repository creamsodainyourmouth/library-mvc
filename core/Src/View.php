<?php

namespace core\Src;
use Error;
use core\Src\CoreSettings as CS;

class View
{
    private string $root_dir;
    private string $layout_path;
    private string $template_path;
    private array $data = [];

    public function __construct(string $template_path="", array $data=[])
    {
        $this->root_dir = CS::get_root_views_dir();
        $this->layout_path = $this->root_dir.'/layout/base.php';
        $this->template_path = $template_path;
        $this->data = $data;
    }

    public function __toString(): string
    {
        return $this->render($this->template_path, $this->data);
    }

    public function render(string $template_path="", array $data=[]): string
    {
        if (empty($template_path)) $template_path = $this->template_path;
        $template_path = $this->root_dir."/$template_path.php";

        if (!(file_exists($template_path) && file_exists($this->root_dir))) {
            throw new Error('Error render. Template does not exist');
        }

        extract($data);
        ob_start();
        require_once $template_path;
        $content = ob_get_clean();
        return require_once $this->layout_path;
    }

}