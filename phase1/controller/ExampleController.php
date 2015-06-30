<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../model/ExampleModel.php');
require_once(__DIR__ . '/../html/view/SampleXHPView.php');
require_once(__DIR__ . '/../html/view/lib/composer/vendor/autoload.php');

class ExampleController extends ControllerBase {

  public function __construct() {
    parent::__construct(get_class($this));
  }

  <<Override>>
  public function execute(Map<string, mixed> $inputs): void {
    // The following is just an example to invoke model class.
    // There is no relationship b/w model and view in this example.
    (new \Model\ExampleModel())->getData($inputs);
  
    $this->render(<sample:xhp:view />);
  }

}

