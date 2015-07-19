<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../model/DashboardModel.php');
require_once(__DIR__ . '/../html/view/SampleXHPView.php');
require_once(__DIR__ . '/../html/view/DashboardView.php');

class DashboardController extends ControllerBase {

  public function __construct() {
    parent::__construct(get_class($this), '/dashboard');
  }

  <<Override>>
  public function execute(\Core\Context $context): void {
    // The following controller connects to Provider's dashboard model class.
    // There is no relationship b/w model and view in this example.

    $provider = (new \Model\DashboardModel())->getData($context->m_request->m_params);
  
    $view = <Dashboard:xhp:view provider={$provider}/>;
    $this->render($view->toString()); 
  }

}

