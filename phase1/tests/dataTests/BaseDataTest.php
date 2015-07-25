<?hh

namespace Tests\DataTests;

require_once(__DIR__ . '/../../DataLayer/MySqlDataFatory.php');
require_once(__DIR__ . '/../../DataLayer/DataImpl.php');

class BaseDataConnectivityTest extends \PHPUnit_Framework_TestCase {

  public function testGetData() {
    $dataConnectionFactory = new MySqlDataConnectionFactory();
    $dataFactory = new DataFactory();

    $userFactory = $dataFactory.GetUserDataFactory($dataConnectionFactory);

    $users = $userFactory.GetUserByName('HippoTestUser1');

    echo $users;

/*
    // By default, ExampleModel returns an array with the followings:
    // 'a' => 1, 'b' => 2, 'c' => 3.
    $this->assertEquals(
      Map{'a' => 1, 'b' => 2, 'c' => 3},
      $model->getData(Map{}));

    // Test if the input array is merged to the defaults.
    $this->assertEquals(
      Map{'a' => 1, 'b' => 2, 'c' => 3, 'hello' => 'test'},
      $model->getData(Map{'hello' => 'test'}));
      */
  }

}

