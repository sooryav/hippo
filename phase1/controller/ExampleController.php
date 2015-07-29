<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../model/ExampleModel.php');
require_once(__DIR__ . '/../html/view/ExamplePageView.php');
require_once(__DIR__ . '/../core/Context.php');

class ExampleController extends ControllerBase {

  public function __construct(\Core\Context $context) {
    parent::__construct(get_class($this), '/example', $context);
  }

  <<Override>>
  public function render(): :x:element {
    return <example:page:view success="Success Attribute Value"/>;
  }

}
