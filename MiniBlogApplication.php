<?php

class MiniBlogApplication extends Application
{
  protected $login_action = ['account', 'signin'];

  public function getRootDir()
  {
    return dirname(__FILE__);
  }

  public function registerRoutes()
  {
    return array(
      '/account'
        => array('controller' => 'account', 'action' => 'index'),
      '/account/:action'
        => array('controller' => 'account'),
    );
  }

  protected function configure()
  {
    $this->db_manager->connect(
      'master',
       array(
         'dsn'      => 'mysql:dbname=mini_blog;host=localhost',
         'user'     => 'mini_blog_user',
         'password' => 'mini_blog_user'
       )
    );
  }
}