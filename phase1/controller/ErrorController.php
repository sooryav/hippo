<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../core/Context.php');
require_once(__DIR__ . '/../html/view/ErrorPageView.php');
require_once(__DIR__ . '/../lib/composer/vendor/autoload.php');

class ErrorController extends ControllerBase {

  public function __construct(\Core\Context $context, Map<string, string> $inputs) {
    parent::__construct(get_class($this), '/error', $context, $inputs);
  }

  public function render(): :x:element {
    return <error:page:view inputs={$this->getInputs()} />;
  }

}
