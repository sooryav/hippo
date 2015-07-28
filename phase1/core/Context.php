<?hh

namespace Core;

require_once( __DIR__ . '/../model/DatabaseHandler.php'); //Require DB connection
require_once(__DIR__ . '/Request.php');

// Context class stores resources such as logger, which can
// be used throughout a request. Be very cautious adding memebers
// to this class as it can become unmanagable easily.
class Context {

  private
    $m_dbConnection = null;

  public function __construct(
    public LoggerInterface $m_logger,
    public Request $m_request) {
  }

  public function getLogger() {
    return $this->m_logger;
  }

  public function getRequest() {
    return $this->m_request;
  }

  public function getDBConnection() {
    //if ($this->m_dbConnection === null) {
      $this->m_dbConnection = (new \Model\DatabaseHandler())->getDBConnection();
    //}
    return $this->m_dbConnection;
  }

}
