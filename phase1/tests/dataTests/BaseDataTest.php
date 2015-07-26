<?hh

namespace Tests\DataTests;
namespace DataAccessLayer;

require_once(__DIR__ . '/../../DataLayer/MySqlDataFatory.php');
require_once(__DIR__ . '/../../DataLayer/DataImpl.php');

class BaseDataConnectivityTest extends \PHPUnit_Framework_TestCase {

  public function testUserData() {
    $userName = 'HippoTestUser1';

    echo 'Starting test';
    echo "\n";
    $dataConnectionFactory = new \DataAccessLayer\MySqlDataConnectionFactory();
    $dataFactory = new \DataAccessLayer\DataFactory();

    $userFactory = $dataFactory->GetUserDataFactory($dataConnectionFactory);

    $user = new User();
    $user->m_userName = $userName;
    $user->m_password = "Password";
    $user->m_userToken = "1234Abcd";
    $user->m_activationToken = 2;   

    $userFactory->AddUser($user);
    
    $user = $userFactory->GetUserByName($userName);

    var_dump($user);

    $this->assertEquals($user->m_userName, $userName);
  }

}

