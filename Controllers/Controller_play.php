<?php

class Controller_play extends Controller{

  public function action_play(){
    $m = Model::getModel();
    $data = $m->getAllPlayer();
    $this->render('play', ['play' => $data]);
  }

  public function action_default(){
    $this->action_play();
  }

  public function action_processPlay(){
    $m = Model::getModel();
    $m->processPlay();
    $this->action_play();
  }


}