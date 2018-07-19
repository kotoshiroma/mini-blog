<?php

class UserRepository extends DbRepository
{
  /*
    insert
    hashPassword
    fetchByUserName
    isUniqueUserName
    fetchAllFollowingsByUserId
   */
  public function insert($user_name, $password)
  {
    $password = $this->hashPassword($password);
    $now = new DateTime();

    $sql = "
      INSERT INTO user
        (user_name, password, created_at)
      VALUES
        (:user_name, :password, :created_at)
    ";
    $stmt = $this->execute(
      $sql,
      array(
        ':user_name'  => $user_name,
        ':password'   => $password,
        ':created_at' => $now->format('Y-m-d H:i:s'),
      )
    );
  }

  public function hashPassword($password)
  {
    return sha1($password . 'XXXX');
  }

  public function fetchByUserName($user_name)
  {
    $sql = "SELECT * FROM user WHERE user_name = :user_name";
    return $this->fetch($sql, [':user_name' => $user_name]);
  }

  public function isUniqueUserName($user_name)
  {
    $sql = "SELECT COUNT(id) as count FROM user WHERE user_name = :user_name";
    $row = $this->fetch($sql, [':user_name' => $user_name]);
    if ($row['count'] === '0') {
      return true;
    }
    return false;
  }

  public function fetchAllFollowingsByUserId($user_id)
  {
    $sql = "
      SELECT u.*
      FROM
        user u LEFT JOIN
        following f ON 
          u.id = f.following_id
      WHERE
        f.user_id = :user_id
    ";

    return $this->fetchAll($sql, [':user_id' => $user_id]);
  }
}