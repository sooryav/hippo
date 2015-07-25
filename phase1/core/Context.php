<?hh

namespace Core;

require_once( __DIR__ . '/../model/DatabaseHandler.php'); //Require DB connection
require_once( __DIR__ . '/../html/languages/en.php');
require_once(__DIR__ . '/../model/Mail.php');
require_once(__DIR__ . '/../model/LoggedInUser.php');
require_once(__DIR__ . '/../model/User.php');
require_once(__DIR__ . '/../model/Util.php');
require_once(__DIR__ . '/Request.php');

// Context class stores resources such as logger, which can
// be used throughout a request. Be very cautious adding memebers
// to this class as it can become unmanagable easily.
class Context {
  const bool EMAIL_ACTIVATION = false;
  const string MAIL_TEMPLATES_DIR = __DIR__ . '/../html/view/templates/';
  const string WEBSITE_NAME = 'Hippo';
  const string WEBSITE_URL = 'localhost';
  const string EMAIL_ADDRESS = 'hippos@hippo.com';
  const string RESEND_ACTIVATION_THRESHOLD = '0';
  const string DB_TABLE_PREFIX = 'test.test_';
  const string LANGUAGE = __DIR__ . '/../html/languages/en.php';
  const int MASTER_ACCOUNT = -1;


  private
    $m_dbConnection = null,
    $m_errors = array(),
    $m_logged_in_user = null;

  public function __construct(
    public LoggerInterface $m_logger,
    public Request $m_request) {
  }

  public function getLogger() {
    return $this->m_logger;
  }

  public function getLoggedInUser() {
    if ($this->m_logged_in_user == null &&
        isset($_SESSION["userCakeUser"]) &&
        is_object($_SESSION["userCakeUser"])) {
      $this->m_logged_in_user = $_SESSION["userCakeUser"];
    }
    return $this->m_logged_in_user;
  }

  public function setLoggedInUser(\Model\LoggedInUser $loggedInUser) {
    $_SESSION["userCakeUser"] = $loggedInUser;
    $this->m_logged_in_user = $loggedInUser;
  }

  public function getDBConnection() {
    //if ($this->m_dbConnection === null) {
      $this->m_dbConnection = (new \Model\DatabaseHandler())->getDBConnection();
    //}
    return $this->m_dbConnection;
  }

  public function getDBTablePrefix() {
    return self::DB_TABLE_PREFIX;
  }

  public function getErrors() {
    return $this->m_errors;
  }

  public function appendError(string $str) {
    $this->m_errors[] = $str;
  }

  public function getDefaultHooks() {
    return array('#WEBSITENAME#','#WEBSITEURL#','#DATE#');
  }

  public function getDefaultReplace() {
    return array(
      self::WEBSITE_NAME,
      self::WEBSITE_URL,
      date('dmy'),
    );
  }

}
