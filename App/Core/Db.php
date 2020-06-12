<?php
namespace App\Core;

class Db 
{
  private $instance;
  private $host;
  private $name;
  private $user;
  private $pass;
  private $charset;

  public function __construct()
  {
    $this->host    = DB_HOST;
    $this->name    = DB_NAME;
    $this->user    = DB_USER;
    $this->pass    = DB_PASS;
    $this->charset = DB_CHARSET;
  }

  /**
   * Método para conectar com o banco de dados
   *
   * @return \PDO
   */
  protected function connect(): \PDO
  {
    try {
      $this->instance = new \PDO('mysql:host='.$this->host.';dbname='.$this->name.';charset='.$this->charset,
    $this->user, $this->pass );
      return $this->instance;
    } catch (\PDOException $e) {
      die("Eitta, não foi possível conectar na base de dados.".$e->getMessage());
    }
  }
}