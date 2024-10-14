<?php

namespace FayFay;
use FayFay\Controller;

class Controller_play extends Controller{

  public function action_play(){
    $m = \ModelTest\Model::getModel();
    $data = $m->getAllPlayer();
    $this->render('play', ['play' => $data]);
  }

  public function action_default(){
    $this->action_play();
  }

  public function action_processPlay(){
    $m = \ModelTest\Model::getModel();
    $m->processPlay();
    $this->action_play();
  }


}