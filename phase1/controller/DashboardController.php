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

    if (isset($context->m_request->m_params['GetProfile'])) {

      $provider = (new \Model\DashboardModel())->getProfile($context->m_request->m_params);
  
      $view = <ui:Dashboard provider={$provider} />;
      $this->render($view->toString()); 

      //$jsonRequest = json_encode($context->m_request->m_params);
      //echo $jsonRequest;
    }
    else
    {
      $view = <ui:TopNav />;
      $this->render($view->toString()); 
      //$jsonRequest = json_encode($context->m_request->m_params);
      //echo $jsonRequest;
    }
  }

}

