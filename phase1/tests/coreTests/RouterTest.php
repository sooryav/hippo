<?hh

namespace Tests\CoreTests;

require_once(__DIR__ . '/../../core/Router.php');
require_once(__DIR__ . '/../mock/MockLogger.php');

class RouterTest extends \PHPUnit_Framework_TestCase {

  public function testRouterWithUnknownKey() {
    $router = new \Core\Router(ImmMap{});
    $context = new \Core\Context(
      new \Tests\Mock\MockLogger(),
      new \Core\Request("foo", Map{}));

    try {
      $router->route(__DIR__, $context);
      $this->fail("Router is expected to throw an exception.");
    }
    catch (\Exception $e) {
      $this->assertEquals(
        "The route [foo] is unknown.",
	$e->getMessage());
    }
  }

}

