<?php
namespace FayFay;
use FayFay\Controller;
class Controller_home extends Controller{

  public function action_home(){
    $m = \ModelTest\Model::getModel();
    $this->render('home');
  }

  public function action_default(){
    $this->action_home();
  }

  public function action_list(){
    $m = \ModelTest\Model::getModel();
    $data = $m->getAllPlayer();
    $this->render('list', ['list' => $data]);
  }
}

?>
