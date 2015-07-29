<?hh

namespace Tests\CoreTests;

require_once(__DIR__ . '/../../core/RequestParams.php');

class RequestParamsTest extends \PHPUnit_Framework_TestCase {

  public function testRequestParams() {
    $requestParams = new \Core\RequestParams(
      Map{
        "hello" => "world",
        "testIntStr" => "1",
        "testInt" => 2,
        "testFloatStr" => "1.5",
        "testFloat" => 2.5
      }
    );
    
    $this->assertEquals("world", $requestParams->getString("hello"));
    $this->assertNull($requestParams->getInt("hello"));
    $this->assertNull($requestParams->getFloat("hello"));

    $this->assertEquals(1, $requestParams->getInt("testIntStr"));
    $this->assertEquals(1.0, $requestParams->getFloat("testIntStr"));
    $this->assertEquals("1", $requestParams->getString("testIntStr"));

    $this->assertEquals(2, $requestParams->getInt("testInt"));
    $this->assertEquals(2.0, $requestParams->getFloat("testInt"));
    $this->assertNull($requestParams->getString("testInt"));

    $this->assertEquals(1.5, $requestParams->getFloat("testFloatStr"));
    $this->assertEquals(1, $requestParams->getInt("testFloatStr"));
    $this->assertEquals("1.5", $requestParams->getString("testFloatStr"));

    $this->assertEquals(2.5, $requestParams->getFloat("testFloat"));
    $this->assertEquals(2, $requestParams->getInt("testFloat"));
    $this->assertNull($requestParams->getString("testFloat"));

    $this->assertNull($requestParams->getInt("dummy"));
    $this->assertEquals(false, $requestParams->isEmpty());
  }

}

