<?hh

namespace Tests\CoreTests;

require_once(__DIR__ . '/../../core/Router.php');

class RouterTest extends \PHPUnit_Framework_TestCase {

  public function testRouterWithUnknownKey() {
    $router = new \Core\Router(Map<string, string>{});

    try {
      $router->route(__DIR__, "unknwon", Map<string, mixed>{});
      $this->fail("Router is expected to throw an exception.");
    }
    catch (\Exception $e) {
      $this->assertEquals(
        "The route [unknwon] is unknown.",
	$e->getMessage());
    }
  }

}

