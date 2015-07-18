<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../model/ExampleModel.php');
require_once(__DIR__ . '/../html/view/SampleXHPView.php');

class ExampleController extends ControllerBase {

  public function __construct() {
    parent::__construct(get_class($this), '/example');
  }

  <<Override>>
  public function execute(\Core\Context $context): void {
    // The following is just an example to invoke model class.
    // There is no relationship b/w model and view in this example.
    (new \Model\ExampleModel())->getData($context->m_request->m_params);
  
    $view = <sample:xhp:view />;
    $this->render($view->toString());
  }

}

