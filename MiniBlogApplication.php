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
      '/'
        => array('controller' =>  'status', 'action' => 'index'),
      '/status/post'
        => array('controller' =>  'status', 'action' => 'post'),
      '/user/:user_name'
        => array('controller' =>  'status', 'action' => 'user'),
      '/user/:user_name/status/:id'
        => array('controller' =>  'status', 'action' => 'show'),

      '/account'
        => array('controller' => 'account', 'action' => 'index'),
      '/account/:action'
        => array('controller' => 'account'),

      'follow'
        => array('controller' => 'account', 'action' => 'follow'),
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