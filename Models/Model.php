<?php

namespace ModelTest;

use PDO;
use PDOException;

class Model
{


    /**
     * Attribut contenant l'instance PDO
     */
    private $bd;


    /**
     * Attribut statique qui contiendra l'unique instance de Model
     */
    private static $instance = null;


    /**
     * Constructeur : effectue la connexion à la base de données.
     */
    private function __construct()
    {

        try {
            include 'Utils/credentials.php';
            $this->bd = new PDO($dsn, $login, $mdp);
            $this->bd->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->bd->query("SET nameS 'utf8'");
        } catch (PDOException $e) {
            die('Echec connexion, erreur n°' . $e->getCode() . ':' . $e->getMessage());
        }
    }


    /**
     * Méthode permettant de récupérer un modèle car le constructeur est privé (Implémentation du Design Pattern Singleton)
     */
    public static function getModel()
    {

        if (is_null(self::$instance)) {
            self::$instance = new Model();
        }
        return self::$instance;
    }

    public function getAllPlayer()
    {
        $req = "SELECT * FROM players";
        $res = $this->bd->query($req);
        return $res->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addPlayer($info)
    {
        try {
            $req = $this->bd->prepare("INSERT INTO players (name, nickname, email, phone) VALUES (:name, :nickname, :email, :phone)");
            $req->bindValue(':name', $info['name']);
            $req->bindValue(':nickname', $info['nickname']);
            $req->bindValue(':email', $info['email']);
            $req->bindValue(':phone', $info['phone']);
            return $req->execute();
        } catch (PDOException $e) {
            
            die('Echec ajout le pseudo est déjà utilisé');
        }
    }

    public function getPlayerNickname($id)
    {
        $req = $this->bd->prepare("SELECT nickname FROM players WHERE id = :id");
        $req->bindValue(':id', $id);
        $req->execute();
        return $req->fetch(PDO::FETCH_ASSOC)['nickname'];
    }

    public function sendTirageToDB($tab)
{
    $numeros = '{' . implode(',', $tab['number']) . '}';
    $etoiles = '{' . implode(',', $tab['stars']) . '}';
    $req = $this->bd->prepare("INSERT INTO tirageloto (numeros, etoiles) VALUES (:numeros, :etoiles)");
    $req->bindValue(':numeros', $numeros, PDO::PARAM_STR);
    $req->bindValue(':etoiles', $etoiles, PDO::PARAM_STR);
    return $req->execute();
}
}
