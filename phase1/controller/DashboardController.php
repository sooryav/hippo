<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../model/DashboardModel.php');
require_once(__DIR__ . '/../html/view/SampleXHPView.php');
require_once(__DIR__ . '/../html/view/DashboardView.php');

class DashboardController extends ControllerBase {

  public function __construct(\Core\Context $context, Map<string, string> $inputs) {
    parent::__construct(get_class($this), '/dashboard', $context, $inputs);
  }

  <<Override>>
  public function render(): :x:element {
    // The following controller connects to Provider's dashboard model class.

    $context = $this->getContext();
    if (isset($context->m_request->m_params['GetProfile'])) {

      $provider = (new \Model\DashboardModel())->getProfile($context->m_request->m_params);
  
      return <ui:Dashboard provider={$provider} />;
      //$jsonRequest = json_encode($context->m_request->m_params);
      //echo $jsonRequest;
    } else {
      $jsonRequest = json_encode($context->m_request->m_params);
      echo $jsonRequest;
      return <ui:TopNav />;
    }
  }

}

