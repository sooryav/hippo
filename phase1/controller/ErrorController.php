<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');

class ErrorController extends ControllerBase {

  public function __construct() {
    parent::__construct(get_class($this), '/error');
  }

  <<Override>>
  public function execute(\Core\Context $context): void {
    $params = $context->m_request->m_params;

    echo "<HTML>\n"
      . "<HEAD><Title>Error Page</TITLE></HEAD>\n"
      . "<BODY>\n"
      . "<p>" . (string)$params['message'] . "</p>"
      . "</BODY>\n"
      . "</HTML>\n";
  }

}

