<?php

namespace App\Core;

class Core
{

  //url
  private $uri = [];

  public function __construct()
  {

    $this->dispatch();
  }

  /**
   * Método para filtrar e separar os elementos da url
   *
   * @return array
   */
  private function filterUrl(): ?array
  {
    if (isset($_GET['url'])) {
      $this->uri = $_GET['url'];
      $this->uri = rtrim($this->uri, '/');
      $this->uri = filter_var($this->uri, FILTER_SANITIZE_URL);
      //separa a string (url) pela barra (min)
      $this->uri = explode('/', strtolower($this->uri));
      return $this->uri;
    }
    return $this->uri;
  }


  /**
   * Método para carregar e executar de forma automática o controladdor
   * solicitado pelo usu[ario e o método passando parâmetros pra ele
   * @return void
   */
  public function dispatch(): void
  {
    $this->filterUrl();

    if (isset($this->uri[0])) {
      //atribui nosso controlador de indíce 0
      $currentController = $this->uri[0];
      //elimina o indíce 
      unset($this->uri[0]);
    } else {
      $currentController = 'home';
    }

    $currentController = ucfirst($currentController);

    // Execução do controlador, verificamos se tem a classe com o nome do controlador solicitado
    $controller = $currentController . 'Controller';

    //Execução do método solicitado
    if (isset($this->uri[1])) {
      $method = str_replace('-', '_', $this->uri[1]);

      $prefix = '\App\\Controllers\\';
      $newController = $prefix . $controller;
   
      $controllerInstance = new $newController;

   
      //verifica se existe ou não o método dentro do controlador solicitado
      if (!method_exists($controllerInstance, $method)) {
        $controller = 'Error';
        $currentMethod = 'index';
        $currentController = 'Error';
      } else {
        $currentMethod = $method;
    
      }
      //elimina o indíce 
      unset($this->uri[1]);
    } else {
      $currentMethod = 'index';
    }


    //Obtendo os parâmetros da uri
    $params = array_values(empty($this->uri) ? [] : $this->uri);
   

    $prefix = '\App\\Controllers\\';
    $newController = $prefix . $controller;

    if (!file_exists('App/Controllers/' . $controller . '.php') || !method_exists($newController, $currentMethod)) {
   
      $newController = $prefix . 'ErrorController';
      $currentMethod = 'index';
    }

    $controller = new $newController;

    //chama o método solicitado pelo usuário
    if (empty($params)) {
      call_user_func([$controller, $currentMethod], $params);
    } else {
      call_user_func_array([$controller, $currentMethod], $params);
    }

    return;
  }

  /**
   * Executa a estrutura
   *
   * @return void
   */
  public static function run(): void
  {
    $core = new self;
    return;
  }
}
