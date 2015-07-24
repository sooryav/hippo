<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../model/ExampleModel.php');
require_once(__DIR__ . '/../html/view/ExamplePageView.php');
require_once(__DIR__ . '/../core/Context.php');

class ExampleController extends ControllerBase {

  public function __construct(\Core\Context $context, Map<string, string> $inputs) {
    parent::__construct(get_class($this), '/example', $context, $inputs);
  }

  <<Override>>
  public function render(): :x:element {
    // The following is just an example to invoke model class.
    // There is no relationship b/w model and view in this example.
    (new \Model\ExampleModel())->getData($this->getInputs());
    return <example:page:view success="Success Attribute Value"/>;
  }

}
