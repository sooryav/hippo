<?php

namespace Tests\ModelTests;

require_once(__DIR__ . '/../../model/ExampleModel.php');

class ExampleModelTest extends \PHPUnit_Framework_TestCase
{
    public function testGetData()
    {
        $model = new \Model\ExampleModel();
    
        // By default, ExampleModel returns an array with the followings:
        // 'a' => 1, 'b' => 2, 'c' => 3.
        $this->assertEquals(
            array('a' => 1, 'b' => 2, 'c' => 3),
            $model->getData([]));

        // Test if the input array is merged to the defaults.
        $this->assertEquals(
            array('a' => 1, 'b' => 2, 'c' => 3, 'hello' => 'test'),
            $model->getData(['hello' => 'test']));
    }
}

?>
