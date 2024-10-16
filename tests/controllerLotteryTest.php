<?php

class controllerLotteryTest extends PHPUnit\Framework\TestCase
{

    public function testLottery()
    {
        $results = ((new \Controllers\controller_lottery)->tireResultatLoto());
        $this->assertIsArray($results);
        $this->assertIsArray($results['number']);
        $this->assertIsArray($results['stars']);
        $this->assertCount(5, $results['number']);
        $this->assertCount(2, $results['stars']);
    }


    public function testActionRun()
    {
        $controller = new \Controllers\controller_lottery();

        $tirage = [
            'number' => [1, 2, 3, 4, 5],
            'stars' => [1, 2]
        ];

        $gilleJoueur = [
            'loto' => [
                23 => [

                    'number' => [1, 2, 3, 4, 5],
                    'stars' => [1, 2]

                ],
                24 => [

                    'number' => [7, 6, 8, 9, 5],
                    'stars' => [7, 1]

                ],
                25 => [

                    'number' => [9, 8, 7, 6, 5],
                    'stars' => [9, 2]

                ],
                26 => [

                    'number' => [9, 8, 7, 6, 5],
                    'stars' => [9, 2]

                ]
            ]
        ];
        $resultats = ($controller->run($gilleJoueur, $tirage));
        $this->assertArrayHasKey('position', $resultats);
        $this->assertArrayHasKey('tirage', $resultats);
        $this->assertEquals(7, $resultats['position'][23]['score']);
        $this->assertEquals(2, $resultats['position'][24]['score']);
        $this->assertEquals([1, 2, 3, 4, 5], $resultats['tirage']['number']);
        $this->assertEquals([1, 2], $resultats['tirage']['stars']);
    }

    public function testActionGain()
    {

        $controller = new \Controllers\controller_lottery();

        $tirage = [
            'number' => [1, 2, 3, 4, 5],
            'stars' => [1, 2]
        ];

        $gilleJoueur = [
            'loto' => [
                23 => [

                    'number' => [1, 2, 3, 4, 5],
                    'stars' => [1, 2]

                ],
                24 => [

                    'number' => [7, 6, 8, 9, 5],
                    'stars' => [7, 1]

                ],
                25 => [

                    'number' => [9, 8, 7, 6, 5],
                    'stars' => [9, 2]
                ],
            ]
        ];

        $results = $controller->gain($gilleJoueur, $tirage, TRUE);
        $this->assertEquals(1480000, $results['listPlayer'][23]['gain']);
        $this->assertEquals(760000, $results['listPlayer'][24]['gain']);
        $this->assertEquals(760000, $results['listPlayer'][25]['gain']);
        $this->assertEquals("1 2 3 4 5 | 1 2", $results['listPlayer'][23]['grille']);
        $this->assertEquals("7 6 8 9 5 | 7 1", $results['listPlayer'][24]['grille']);
    }

    public function testSimulation()
    {

        $controller = new \Controllers\controller_lottery();

        $nbBots= 5;

        $results = $controller->simulation($nbBots);

        $this->assertEquals(5, count($results['loto']));



    }
}
