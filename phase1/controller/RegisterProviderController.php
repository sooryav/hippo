<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../model/Util.php');
require_once(__DIR__ . '/../model/User.php');
require_once(__DIR__ . '/../html/view/RegisterProviderView.php');
require_once(__DIR__ . '/../core/Context.php');

class RegisterProviderController extends ControllerBase {

  public function __construct(\Core\Context $context) {
    parent::__construct(get_class($this), '/register_provider', $context);
  }

  <<Override>>
  public function render(): :x:element {

      return <register:provider:page:view/>;

  }

}
