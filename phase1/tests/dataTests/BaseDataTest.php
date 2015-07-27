<?hh

namespace Tests\DataTests;
namespace DataAccessLayer;

require_once(__DIR__ . '/../../DataLayer/MySqlDataFatory.php');
require_once(__DIR__ . '/../../DataLayer/DataImpl.php');

class DataTests extends \PHPUnit_Framework_TestCase {

  protected function setUp()
  {
      if (!extension_loaded('mysqli')) {
          $this->markTestSkipped(
            'The MySQLi extension is not available.'
          );
      }

      /*
      * Skipping these tests until we figure out creating DB etc.,
      */
      $this->markTestSkipped(
        'DB is not setup. Skipping tests!'
      );
  }

  public function testUserData() {
    $userName = 'HippoTestUser1';

    echo 'Starting User test';
    echo "\n";

    $dataConnectionFactory = new \DataAccessLayer\MySqlDataConnectionFactory();
    $dataFactory = new \DataAccessLayer\DataFactory();

    $userFactory = $dataFactory->GetUserDataFactory($dataConnectionFactory);

    while(true) {
      $user = $userFactory->GetUserByName($userName);
      
      if (!$user) break;
      
      echo "Found an existing user with user name $userName\n";

      $userFactory->DeleteUserById($user->m_userId);
    }

    $user = new User();
    $user->m_userName = $userName;
    $user->m_password = "Password";
    $user->m_userToken = "1234Abcd";
    $user->m_activationToken = 2;   

    $userFactory->AddUser($user);
    
    $user = $userFactory->GetUserByName($userName);

    $this->assertEquals($user->m_userName, $userName);
  }

  public function testProviderData() {
    $providerName = 'HippoTestProvider1';
    $zipCode = '98007';

    echo "Starting Provider test\n";

    $dataConnectionFactory = new \DataAccessLayer\MySqlDataConnectionFactory();
    $dataFactory = new \DataAccessLayer\DataFactory();

    $providerFactory = $dataFactory->GetProviderDataFactory($dataConnectionFactory);

    $providerList = $providerFactory->GetAllProviders($zipCode);
    echo "Found existing providers with Zip code name $zipCode\n";

    $providerList = $providerFactory->GetAllProvidersByName($providerName);
      
    $existingProviderCount = count($providerList);

    if ($existingProviderCount != 0) {
      echo "Found existing providers with user name $providerName with count: $existingProviderCount\n";

      foreach($providerList as $provider) {
        $providerFactory->DeleteProviderById($provider->m_providerId);
      }
    }

    $provider = new Provider();
    $provider->m_providerName = $providerName;
    $provider->m_userId = 1;
    $provider->m_description = "This is a test vendor";
    $provider->m_zipCode = $zipCode;

    $result = false;
    echo "Test: Adding Provider\n";

    try {
      $result = $providerFactory->AddProvider($provider);
    } catch(Exception $e) {
      echo "Exception caught while adding provider: $e->getMessage()";
    }

    echo "Test: Added Provider\n";

    $this->assertEquals($result, true);
    
    $providerList = $providerFactory->GetAllProvidersByName($providerName);

    $this->assertEquals($providerList[0]->m_providerName, $providerName);
  }

}




