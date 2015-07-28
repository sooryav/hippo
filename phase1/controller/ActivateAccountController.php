<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../model/Util.php');
require_once(__DIR__ . '/../html/view/ActivateAccountPageView.php');
require_once(__DIR__ . '/../core/Context.php');

class ActivateAccountController extends ControllerBase {

  public function __construct(\Core\Context $context, Map<string, string> $inputs) {
    parent::__construct(get_class($this), '/activate_account', $context, $inputs);
  }

  <<Override>>
  public function render(): :x:element {

    $context = $this->getContext();

    if (!\Model\Util::securePage($context, $_SERVER['PHP_SELF'])){
      die();
    }
    $errors = array();
    $successes = array();
    //Get token param
    if(isset($_GET["token"])) {
      $token = $_GET["token"];
      if(!isset($token)) {
        $errors[] = \Model\Util::lang("FORGOTPASS_INVALID_TOKEN");
      } else if(!\Model\Util::validateActivationToken($context, $token)) {
        //Check for a valid token. Must exist and active must be = 0
        $errors[] = \Model\Util::lang("ACCOUNT_TOKEN_NOT_FOUND");
      } else {
        //Activate the users account
        if(!\Model\Util::setUserActive($context, $token)) {
          $errors[] = \Model\Util::lang("SQL_ERROR");
        }
      }
    } else {
      $errors[] = \Model\Util::lang("FORGOTPASS_INVALID_TOKEN");
    }

    if(count($errors) == 0) {
      $successes[] = \Model\Util::lang("ACCOUNT_ACTIVATION_COMPLETE");
    }
    return
    <activate:account:page:view
      logged_in_user={$context->getLoggedInUser()}
      errors={$errors}
      successes={$successes}
    />;

  }

}
