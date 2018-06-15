<?php

class Request
{
  public function isPost()
  {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      return true;
    }
    return false;
  }

  public function getGet($name, $default = null)
  {
    if (isset($_GET[$name])) {
      return $_GET[$name];
    }
    return $default;
  }

  public function getPost($name, $default = null)
  {
    if (isset($_POST[$name])) {
      return $_POST[$name];
    }
    return $default;
  }

  public function getHost()
  {
    if(!empty($_SERVER['HTTP_HOST'])) {
      return $_SERVER['HTTP_HOST'];
    }
    return $_SERVER['SERVER_NAME'];
  }

  public function isSsl()
  {
    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on') {
      return true;
    }
    return false;
  }

  /* URL関連のメソッド ----------------------------------------------- */

  public function getRequestUri()
  {
    // URLのホスト名以降の値が返される
    return $_SERVER['REQUEST_URI'];
  }

  public function getBaseUrl()
  {
    // /web/index.php
    $script_name = $_SERVER['SCRIPT_NAME'];
    
    // URL:ホスト名の場合             => /
    // URL:ホスト名/user/signUpの場合 => /user/signUp
    $request_uri = $this->getRequestUri();

    if (0 === strpos($request_uri, $script_name)) {
      // フロントコントローラがURLに含まれている場合
      return $script_name;
    } elseif (0 === strpos($request_uri, dirname($script_name))) {
      // フロントコントローラがURLから省略されている場合
      return rtrim(dirname($script_name), '/');
    }

    return '';
  }

  public function getPathInfo()
  {
    $base_url = $this->getBaseUrl();
    $request_uri = $this->getRequestUri();

    // GETパラメータを取り除く
    $pos = strpos($request_uri, '?');
    if ($pos !== false) {
      $request_uri = substr($request_uri, 0, $pos);
    }

    // REQUEST_URIからベースURLを取り除く
    $path_info = substr($request_uri, strlen($base_url));
    return $path_info;
  }
}