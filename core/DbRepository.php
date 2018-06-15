<?php

abstract class DbRepository
{
  protected $con;

  public function __construct($con)
  {
    $this->setConnection($con);
  }
  
  public function setConnection($con)
  {
    $this->con = $con;
  }

  public function execute($sql, $params = array())
  {
    $stmt = $this->con->prepare($sql); // PDO::prepare() ※戻り値はPDOStatementオブジェクト
    $stmt->execute($params);           // PDOStatuement::execute() ※実行するとオブジェクトに結果セットが格納される
    return $stmt;
  }

  public function fetch($sql, $params = array())
  {
    return $this->execute($sql, $params)->fetch(PDO::FETCH_ASSOC);
  }

  public function fetchAll($sql, $params = array())
  {
    return $this->execute($sql, $params)->fetchAll(PDO::FETCH_ASSOC);
  }
}