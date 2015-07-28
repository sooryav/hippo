<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../model/Util.php');
require_once(__DIR__ . '/../html/view/HomePageView.php');
require_once(__DIR__ . '/../core/Context.php');

class HomePageController extends ControllerBase {

  public function __construct(\Core\Context $context, Map<string, string> $inputs) {
    parent::__construct(get_class($this), '/home', $context, $inputs);
  }

  <<Override>>
  public function render(): :x:element {

    if (!\Model\Util::securePage($this->getContext(), $_SERVER['PHP_SELF'])) {
      die();
    }

    return
      <home:page:view
        logged_in_user={$this->getContext()->getRequest()->getLoggedInUser()}
      />;
  }

}
