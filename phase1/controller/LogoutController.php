<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../model/Util.php');
require_once(__DIR__ . '/../core/Context.php');

class LogoutController extends ControllerBase {

  public function __construct(\Core\Context $context, Map<string, string> $inputs) {
    parent::__construct(get_class($this), '/logout', $context, $inputs);
  }

  <<Override>>
  public function render(): :x:element {
    return <x:frag />;
  }

  <<Override>>
  public function execute(): void {

    $context = $this->getContext();
    if (!\Model\Util::securePage($context, $_SERVER['PHP_SELF'])){
      die();
    }

    //Log the user out
    if (\Model\Util::isUserLoggedIn($context)) {
      $context->getLoggedInUser()->userLogOut();
    }

    header("Location: /login");
    die();
    /*$websiteUrl = \Core\Context::WEBSITE_URL;
    if(!empty($websiteUrl)) {
      $add_http = "";
      if(strpos($websiteUrl, "http://") === false) {
        $add_http = "http://";
      }
      header("Location: " . $add_http . $websiteUrl);
      die();
    } else {
      header("Location: http://" . $_SERVER['HTTP_HOST']);
      die();
    }*/
  }

}
