<?php

class StatusController extends Controller
{
  protected $auth_actions = ['index', 'post'];

  public function indexAction()
  {
    $user = $this->session->get('user');
    $statuses = $this->db_manager->get('Status')->fetchAllPersonalArchivesByUserId($user['id']);

    return $this->render([
      'statuses' => $statuses,
      'body'     => '',
      '_token'   => $this->generateCsrfToken('status/post')
    ]);
  }

  public function postAction()
  {
    // HTTPメソッドチェック
    if (!$this->request->isPost()) {
      $this->forward404();
    }
    // ワンタイムトークンチェック
    $token = $this->request->getPost('_token');
    if (!$this->checkCsrfToken('status/post', $token)) {
      $this->redirect('/');
    }

    // バリデーション
    $body = $this->request->getPost('body');
    $errors = array();

    if (!strlen($body)) {
      $errors[] = '一言を入力してください';
    } else if (mb_strlen($body) > 200) {
      $errors[] = '200文字以内で入力してください';
    }
    // バリデーション成功時の一言投稿(レコード作成)
    if (count($errors) === 0) {
      $user = $this->session->get('user');
      $this->db_manager->get('Status')->insert($user['id'], $body);
      return $this->redirect('/');
    }
    // バリデーションエラー時の再render
    $user = $this->session->get('user');
    $statuses = $this->db_manager->get('Status')->fetchAllPersonalArchivesByUserId($user['id']);
    return $this->render([
      'errors'   => $errors,
      'statuses' => $statuses,
      'body'     => $body,
      '_token'   => $this->generateCsrfToken('status/post')
    ], 'index');
  }

  public function userAction($params) // TODO:($paramsの仕組みを調べる)
  {
    // ユーザが削除されている場合も考えられるため、存在チェックを行う。(ユーザ名とidどちらを使うかは任意)
    $user = $this->db_manager->get('User')->fetchByUserName($params['user_name']);
    if (!$user) {
      $this->forward404();
    }

    $statuses = $this->db_manager->get('Status')->fetchAllByUserId($user['id']);

    $following = null;
    if ($this->session->isAuthenticated()) {
      $my = $this->session->get('user');
      if ($my['id'] !== $user['id']) {
        $following = $this->db_manager->get('Following')->isFollowing($my['id'], $user['id']);
      }
    }

    return $this->render([
      'user'     => $user,
      'statuses' => $statuses,
      'following' => $following,
      '_token'    => $this->generateCsrfToken('account/follow')
    ]);
  }

  public function showAction($params)
  {
    $status = $this->db_manager->get('Status')->fetchByIdAndUserName($params['id'], $params['user_name']);

    if (!$status) {
      $this->forward404();
    }

    return $this->render(['status' => $status]);
  }
}