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
    (new \Model\ExampleModel())->getData($inputs);
  
    // TODO: Not sure how to call parent::render();
    echo <sample:xhp:view />;
  }

}

