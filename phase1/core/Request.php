<?hh

namespace Core;

require_once(__DIR__ . '/../core/RequestParams.php');
require_once(__DIR__ . '/../model/LoggedInUser.php');

// Request class contains request-specific information.
class Request {

  private string $m_uri;
  private RequestParams $m_params;
  private $m_logged_in_user = null;

  // $m_url: the request URI without the query string.
  //   If the original request URI was /foo/?bar=1,
  //   the $m_url passed in should be /foo.
  // $m_params: request parameters (such as from $_GET or $_POST).
  public function __construct(
    string $uri,
    RequestParams $params) {

    $this->m_uri = $uri;
    $this->m_params = $params;
  }

  public function getUri(): string {
    return $this->m_uri;
  }

  public function getParams(): RequestParams {
    return $this->m_params;
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

}
