<?php

namespace App\Core;

use App\Core\Db;

class Crud extends Db
{
  private static $db;
  private static $stm;

  public static function query($sql, $params = [])
  {
    self::$db = new Db;
    //conexão
    self::$stm = self::$db->connect();
    //checkpoint
    self::$stm->beginTransaction();
    $query = self::$stm->prepare($sql);

    //se houver erros
    if(!$query->execute($params)){
     
      self::$stm->rollBack();
      $error = $query->errorInfo();
      //pega a mensagem de erro
      throw new \Exception($error[2]);
    }

    //SELECT | INSERT | UPDATE | DELETE
    if(strpos($sql, 'SELECT') !== false){
    
      $res = $query->rowCount() > 0 ? $query->fetchAll(\PDO::FETCH_OBJ) : false;
    
      return $res;
    }elseif(strpos($sql, 'INSERT') !== false){
      $id = self::$stm->lastInsertId();
      self::$stm->commit();
      return true;
    }elseif(strpos($sql, 'UPDATE') !== false){
      self::$stm->commit();
      return true;
    }elseif(strpos($sql, 'DELETE') !== false){
      if($query->rowCount() > 0){
        self::$stm->commit();
        return true;
      }
      self::$stm->rollBack();
      return false;
    }


  }
}
