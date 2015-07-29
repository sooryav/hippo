<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../model/DashboardModel.php');
require_once(__DIR__ . '/../html/view/SampleXHPView.php');
require_once(__DIR__ . '/../html/view/DashboardView.php');

class DashboardController extends ControllerBase {

  public function __construct(\Core\Context $context) {
    parent::__construct(get_class($this), '/dashboard', $context);
  }

  <<Override>>
  public function render(): :x:element {

    // The following controller connects to Provider's dashboard model class.

    $params = $this->getRequestParams();

    $profile = $params->getString('GetProfile');

    if (!is_null($profile)) {
      $provider = (new \Model\DashboardModel())->getProfile();
  
      return <ui:Dashboard provider={$provider} />;
    }
    else {
      // TODO: This will probably not work since params type has changed.
      $jsonRequest = json_encode($params);
      echo $jsonRequest;
      return <ui:TopNav />;
    }
  }

}

