<?php

class View 
{
  protected $view_dir; 
  protected $defaults; 
  protected $layout_variables = array();
  
  public function __construct($view_dir, $defaults = array()) // 渡される$view_dirは、application->getViewDir()の値
  {
    $this->view_dir = $view_dir;
    $this->defaults = $defaults;
  }

  public function setLayoutVar($name, $value)
  {
    $this->layout_variables[$name] = $value;
  }

  public function render($_view_file_path, $_variables = array(), $_layout = false) // 渡される$_pathは、基本、"コントローラ名/アクション名"
  {
    extract(array_merge($this->defaults, $_variables));

    $_file = $this->view_dir . '/' . $_view_file_path . '.html';
    ob_start();
    ob_implicit_flush(0);
    require $_file;
    $content = ob_get_clean();

    if ($_layout) {
      $content = $this->render($_layout, array_merge($this->layout_variables, ['_content' => $content]));
    }

    return $content;
  }

  public function escape($string)
  {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
  }
}