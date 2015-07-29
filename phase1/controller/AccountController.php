<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../model/Util.php');
require_once(__DIR__ . '/../html/view/AccountPageView.php');
require_once(__DIR__ . '/../core/Context.php');

class AccountController extends ControllerBase {

  public function __construct(\Core\Context $context) {
    parent::__construct(get_class($this), '/account', $context);
  }

  <<Override>>
  public function render(): :x:element {

    $context = $this->getContext();

    if (!\Model\Util::securePage($context, $_SERVER['PHP_SELF'])){
      die();
    }

    if (!\Model\Util::isUserLoggedIn($context)) {
      header('Location: /login');
      die();
    }

    return
      <account:page:view
        logged_in_user={$context->getRequest()->getLoggedInUser()}
      />;
  }

}
