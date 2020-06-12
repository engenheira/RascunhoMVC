<?php 
namespace App\Core;

class View 
{
  /**
   * Método para redenrizar a view
   *
   * @param string $view
   * @param array $arrayData
   * @return void
   */
  public static function render($view, $arrayData = [])
  {
    $data = (object)$arrayData; 
   

    if(!is_file("templates/views/$view.php")){
      echo 'Não existe essa página';
      die();
    }

    $dir = "templates/views/$view.php";
    require_once $dir;
    exit();
  }
}