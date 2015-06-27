<?php

namespace Tests\CoreTests;

require_once(__DIR__ . '/../../core/Router.php');

class RouterTest extends \PHPUnit_Framework_TestCase
{
    public function testRouterWithUnknownKey()
    {
        $router = new \Core\Router([]);
    
        try
        {
            $router->route(__DIR__, "unknwon", []);
	    $this->fail("Router is expected to throw an exception.");
        }
        catch (\Exception $e)
        {
          $this->assertEquals(
              "The route [unknwon] is unknown.",
              $e->getMessage());
        }
    }
}

?>
