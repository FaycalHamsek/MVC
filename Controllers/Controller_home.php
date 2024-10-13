<?php

class Controller_home extends Controller{

  public function action_home(){
    $m = Model::getModel();
    $this->render('home');
  }

  public function action_default(){
    $this->action_home();
  }

  public function action_list(){
    $m = Model::getModel();
    $data = $m->getAllPlayer();
    $this->render('list', ['list' => $data]);
  }
}

?>
