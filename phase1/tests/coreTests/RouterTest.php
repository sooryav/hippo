<?hh

namespace Tests\CoreTests;

require_once(__DIR__ . '/../../core/Router.php');
require_once(__DIR__ . '/../mock/MockLogger.php');

class RouterTest extends \PHPUnit_Framework_TestCase {

  public function testRouterWithUnknownKey(): void {
    $router = new \Core\Router(ImmMap{});
    $request = new \Core\Request("foo", new \Core\RequestParams(Map{}));
    $context = new \Core\Context(
      new \Tests\Mock\MockLogger(),
      $request);

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

