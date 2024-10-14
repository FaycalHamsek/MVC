<?php

class controllerLotteryTest extends PHPUnit\Framework\TestCase
{

   
        public function testLottery()
    {
        $results = ((new \FayFay\controller_lottery)->tireResultatLoto());
        $this->assertCount(5, $results['number']);
        $this->assertCount(2, $results['stars']);
    }
    

    public function testActionRun()
    {
        $controller = new \FayFay\controller_lottery();

        $loterie = [
            'loto' => [
                [
                    'number' => [1, 2, 3, 4, 5],
                    'stars' => [1, 2]
                ],
                [
                    'number' => [10, 11, 12, 13, 14],
                    'stars' => [8, 9]
                ]
            ]
        ];

        $result = $controller->action_run($loterie);

        $this->assertArrayHasKey('position', $result);
        $this->assertArrayHasKey('tirage', $result);

        // Vérification des scores et du tirage
        $this->assertEquals(5, count($result['tirage']['number']));  // 5 numéros tirés
        $this->assertEquals(2, count($result['tirage']['stars']));   // 2 étoiles tirées
        $this->assertIsArray($result['position']);
    }

    public function testActionGain()
    {
        $controller = $this->getMockBuilder(\FayFay\controller_lottery::class)
            ->onlyMethods(['render'])
            ->getMock();

        // Capture les données passées à render
        $controller->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('results'),
                $this->callback(function ($data) {
                    $this->assertArrayHasKey('listPlayer', $data);
                    $this->assertArrayHasKey('tirageLoto', $data);
                    return true;
                })
            );

        $arrayLottery = [
            'loto' => [
                [
                    'number' => [1, 2, 3, 4, 5],
                    'stars' => [1, 2]
                ]
            ]
        ];

        $controller->action_gain($arrayLottery, true);
    }
}
