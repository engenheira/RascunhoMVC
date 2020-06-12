<?php 
namespace App\Controllers;
use App\Core\View;
use App\Core\Crud;
class TesteController
{
  public function index()
  {
  
    $data = [
      'title' => 'Rascunho MVC',
      'name'  => 'Kelly ALX'
    ];

    View::render('home', $data);
  }

  public function ola()
  {
    $sql = 'SELECT * FROM users WHERE id=:id';
    $res = Crud::query($sql, [':id' => 3]);
   

    // var_dump($res);

   
  }

  public function insere()
  {
    $sql = 'INSERT INTO users (nome, email, created_at) VALUES (:nome, :email, :created_at)';
    $dados = [
      'nome' => 'Paulo',
      'email' => 'paulo@email.com',
      'created_at' => '2020-05-29'
    ];

    // $insert = Crud::query($sql, $dados);
    
  }

  public function update()
  {
    $sql = "UPDATE users SET nome=:nome WHERE id=:id";
    $update = [
      'nome' => 'Pedro',
      'id' => '6'
    ];

    $res = Crud::query($sql, $update);
    var_dump($res);
  }

  public function delete()
  {
    $sql = 'DELETE FROM users WHERE id=:id LIMIT 1';
    $del = Crud::query($sql,['id' => '6']);
    var_dump($del);
  }
}