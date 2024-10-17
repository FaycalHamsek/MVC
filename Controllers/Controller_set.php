<?php
namespace Controllers;
use Controllers\Controller;

class Controller_set extends Controller {

  public function action_add() {

    $m = \ModelTest\Model::getModel();
    // on vérifie si il y a des informations dans le $_POST
    if (isset($_POST['name']) && !preg_match("#^\s*$#", $_POST['name']) &&
      isset($_POST['nickname']) && !preg_match("#^\s*$#", $_POST['nickname']) &&
      isset($_POST['email']) && filter_var($_POST['email'], FILTER_VALIDATE_EMAIL) &&
      isset($_POST['phone']) && preg_match("#^[0-9]*$#", $_POST['phone'])) {

        // On stock ces informations dans un tableau
      $info = [
        'name' => $_POST['name'],
        'nickname' => $_POST['nickname'],
        'email' => $_POST['email'],
        'phone' => $_POST['phone']
      ];
      // on envoie le tableau dans la fonction d'ajout de joueur
      $data = $m->addPlayer($info);
      $this->message("Player data added successfully");
      header("Location: controller=play&action=play");
      exit();
    } else {
      $this->message("Invalid player data");
    }
  }

  public function action_default() {
    $m = \ModelTest\Model::getModel();
    $this->render("add");
  }

  public function message($message = '') {
    $data = [
      'title' => "message",
      'message' => $message
    ];
    $this->render("message", $data);
  }
}