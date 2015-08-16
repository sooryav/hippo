<?hh

namespace Core;
namespace DataAccessLayer;

require_once( __DIR__ . '/../model/DatabaseHandler.php'); //Require DB connection
require_once(__DIR__ . '/Request.php');
require_once(__DIR__ . '/../DataLayer/HippoDataFactoryInterface.php');
require_once(__DIR__ . '/../DataLayer/MySqlDataFactory.php');
require_once(__DIR__ . '/../DataLayer/DataImpl.php');

// Context class stores resources such as logger, which can
// be used throughout a request. Be very cautious adding memebers
// to this class as it can become unmanagable easily.
class Context {

  private LoggerInterface $m_logger;
  private Request $m_request;
  private $m_dbConnection = null;
  private IDataConnectionFactory $m_dbConnectionFactory = new MySqlDataConnectionFactory();
  private IDataFactory $m_dataFactory;
  private IUserDataFactory $m_userDataFactory;
  private IProviderDataFactory $m_providerDataFactory;

  public function __construct(
    LoggerInterface $logger,
    Request $request) {
    
    $this->m_logger = $logger;
    $this->m_request = $request;
    $this->m_dataFactory = new DataFactory($this->m_dbConnectionFactory);
    $this->m_userDataFactory = $this->m_dataFactory->GetUserDataFactory();
    $this->m_providerDataFactory = $this->m_dataFactory->GetProviderDataFactory();
  }

  public function getLogger(): LoggerInterface {
    return $this->m_logger;
  }

  public function getRequest(): Request{
    return $this->m_request;
  }


  public function getDBConnection() {
    //if ($this->m_dbConnection === null) {
      $this->m_dbConnection = (new \Model\DatabaseHandler())->getDBConnection();
    //}
    return $this->m_dbConnection;
  }

  public function GetUserDataFactory() {
    return $this->m_userDataFactory;
  }

  public function GetProviderDataFactory() {
    return $this->m_providerDataFactory;
  }
}
