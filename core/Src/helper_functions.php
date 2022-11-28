<?php

function include_template(string $template_path, array $data = []): string
{
    $template_path = app()->cs::get_root_views_dir() . "/$template_path" . '.php';
    extract($data);
    ob_start();
    require_once $template_path;
    return ob_get_clean();
}
