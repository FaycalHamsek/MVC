<?php

namespace Controllers;

use Controllers\Controller;

class controller_lottery extends Controller
{
    public function action_default()
    {
        $m = \ModelTest\Model::getModel();
        $this->render("home");
    }

    public function tireResultatLoto(): array
    {
        $numbers = array(
            0,
            0,
            0,
            0,
            0
        );

        $stars = array(
            0,
            0
        );

        foreach ($numbers as $key => $num) { # pour chaque nombre de mon tableau numbers
            $numbers[$key] = random_int(1, 49); # on selectionne aléatoirement une valeur entre 1 et 49
        }

        foreach ($stars as $key => $str) { # pour chaque nombre de mon tableau stars
            $stars[$key] = random_int(1, 9); # on selectionne aléatoirement une valeur entre 1 et 9
        }

        $tirage = ['number' => $numbers, 'stars' => $stars]; # on créé un tableau tirage avec les 2 tableaux précédents
        return $tirage;
    }

    public function run(array $loterie, array $tirage): array
    {
        $position = []; #on crée un tableau vide
        foreach ($loterie['loto'] as $key => $val) { # pour chaque valeur de POST['loto'] on fait un tableau avec des clés
            $position[$key]['score'] = 0; # la valeur de ma clé est de 0
            $position[$key]['tirage']['number'] = $val['number']; # la valeur de ma clé est la valeur des numéros de POST
            $position[$key]['tirage']['stars'] = $val['stars']; # la valeur de ma clé est la valeur des stars de POST

            foreach ($val['number'] as $numberPlayer) { # pour chaque numéros de mon premier tableau numéro dans val
                if (in_array($numberPlayer, $tirage['number'])) { # on regarde si il est dans le tableau number de mon tirage
                    $position[$key]['score'] += 1; # si oui on ajoute 1 a la position
                }
            }

            foreach ($val['stars'] as $starPlayer) { # pour chaque étoile de mon deuxieme tableau étoile dans val
                if (in_array($starPlayer, $tirage['stars'])) { # on regarde si il est dans le tableau stars de mon tirage
                    $position[$key]['score'] += 1; # si oui on ajoute 1 a la position
                }
            }
        }
        return [
            "position" => $position,
            "tirage" => $tirage
        ];
    }

    public function gain(array $arrayLottery, array $tirage, bool $simulation = false): array
    {
        $m = \ModelTest\Model::getModel();

        // Tableau de répartition des gains pour les 10 premiers
        $repartition = [
            0.4, // 40% pour le premier
            0.2, // 20% pour le deuxième
            0.12, // 12% pour le troisième
            0.07, // 7% pour le quatrième
            0.06, // 6% pour le cinquième
            0.05, // 5% pour le sixième
            0.04, // 4% pour le septième
            0.03, // 3% pour le huitième
            0.02, // 2% pour le neuvième
            0.01 // 1% pour le dixième
        ];

        // Montant total à répartir
        $somme = 3000000;

        // Récupération des résultats du tirage
        $tmp = $this->run($arrayLottery, $tirage);
        $rank = $tmp["position"];
        $tirage = $tmp["tirage"];

        // Tableau pour stocker les gains de chaque joueur
        $gain = [];
        // Tri des résultats par ordre décroissant
        uasort($rank, function ($a, $b) {
            return $b['score'] <=> $a['score']; // Tri décroissant par score
        });

        // Sélection des 10 premiers résultats
        $topRank = array_slice($rank, 0, 10, true);

        $scoreDoublon = [];
        $i = 0;
        foreach ($topRank as $idPlayer => $player) {
            $topRank[$idPlayer]['tauxGain'] = $repartition[$i];
            if (!isset($scoreDoublon[$player['score']])) {
                $scoreDoublon[$player['score']]['totalPlayer'] = 1;
                $scoreDoublon[$player['score']]['totalTotauxGain'] = $repartition[$i];
            } else {
                $scoreDoublon[$player['score']]['totalPlayer'] += 1;
                $scoreDoublon[$player['score']]['totalTotauxGain'] += $repartition[$i];
            }
            $i++;
        }
        foreach ($topRank as $idPlayer => $player) {
            if ($player['score'] === 0) {
                $gain[$idPlayer] = [
                    'nickname' => $simulation ? 'bot numéro ' . $idPlayer : $m->getPlayerNickname($idPlayer),
                    'grille' => implode(' ', $player['tirage']['number']) . " | " . implode(' ', $player['tirage']['stars']),
                    'gain' => 0
                ];
            } else {
                $gain[$idPlayer] = [
                    'nickname' => $simulation ? 'bot numéro ' . $idPlayer : $m->getPlayerNickname($idPlayer),
                    'grille' => implode(' ', $player['tirage']['number']) . " | " . implode(' ', $player['tirage']['stars']),
                    'gain' => ($scoreDoublon[$player['score']]['totalTotauxGain'] / $scoreDoublon[$player['score']]['totalPlayer']) * $somme
                ];
            }
        }
        $data = [
            'listPlayer' => $gain,
            'tirageLoto' => implode(" ", $tirage['number']) . " | " . implode(' ', $tirage['stars'])
        ];

        return $data;
    }

    public function simulation(int $nbBot): array
    {
        $m = \ModelTest\Model::getModel();
        $return = [];
        if ($nbBot == null) {
            $this->action_error('une erreur est survenue lors de la récupération de la lotterie.');
            die;
        }

        for ($i = 0; $i < $nbBot; $i++) {
            $numbers = array(0, 0, 0, 0, 0);
            $stars = array(0, 0);

            foreach ($numbers as $key => $num) {
                $numbers[$key] = random_int(1, 49);
            }

            foreach ($stars as $key => $str) {
                $stars[$key] = random_int(1, 9);
            }

            $tirage = ['number' => $numbers, 'stars' => $stars];

            $return['loto'][$i] = $tirage;
        }

        return $return;
    }

    public function action_bot()
    {
        $this->sendToRender('simulate');
    }

    public function action_simulation()
    {
        if (isset($_POST['NbBot'])) {
            $tirage = $this->tireResultatLoto(); # on génère un tirage 
            $this->sendToRender('results', $this->gain($this->simulation($_POST['NbBot']), $tirage, true));
        } else {
            $this->action_error('une erreur est survenue lors de la récupération de la lotterie.');
        }
    }

    public function action_jouer()
    {
        if (isset($_POST['loto'])) {
            $tirage = $this->tireResultatLoto(); # on génère un tirage 
            $this->sendToRender('results', $this->gain(['loto' => $_POST['loto']], $tirage));
        } else {
            $this->action_error('une erreur est survenue lors de la récupération de la lotterie.');
        }
    }

    private function sendToRender(string $vue, array $data = [])
    {
        $this->render($vue, $data);
    }
}
