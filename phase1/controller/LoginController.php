<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../model/Util.php');
require_once(__DIR__ . '/../html/view/LoginPageView.php');
require_once(__DIR__ . '/../core/Context.php');

class LoginController extends ControllerBase {

  public function __construct(\Core\Context $context) {
    parent::__construct(get_class($this), '/login', $context);
  }

  <<Override>>
  public function render(): :x:element {

    $context = $this->getContext();
    $errors = array();

    if (!\Model\Util::securePage($context, $_SERVER['PHP_SELF'])){
      die();
    }

    //Prevent the user visiting the logged in page if he/she is already logged in
    if (\Model\Util::isUserLoggedIn($context)) {
      header('Location: /account');
      die();
    }

    $username = "";
    $password = "";
    //Forms posted
    if(!empty($_POST)) {
      $username = \Model\Util::sanitize(trim($_POST["username"]));
      $password = trim($_POST["password"]);

      //Perform some validation
      //Feel free to edit / change as required
      if($username == "") {
        $errors[] = \Model\Util::lang("ACCOUNT_SPECIFY_USERNAME");
      }
      if($password == "") {
        $errors[] = \Model\Util::lang("ACCOUNT_SPECIFY_PASSWORD");
      }

      if(count($errors) == 0) {
        //A security note here, never tell the user which credential was incorrect
        if(!\Model\Util::usernameExists($context, $username)) {
          $errors[] = \Model\Util::lang("ACCOUNT_USER_OR_PASS_INVALID");
        } else {
          $userdetails = \Model\Util::fetchUserDetails($context, $username);
          //See if the user's account is activated
          if($userdetails["active"]==0) {
            $errors[] = \Model\Util::lang("ACCOUNT_INACTIVE");
          } else {
            //Hash the password and use the salt from the database to compare the password.
            $entered_pass = \Model\Util::generateHash($password,$userdetails["password"]);

            if($entered_pass != $userdetails["password"]) {
              //Again, we know the password is at fault here, but lets not give away the combination incase of someone bruteforcing
              $errors[] = \Model\Util::lang("ACCOUNT_USER_OR_PASS_INVALID");
            } else {
              //Passwords match! we're good to go'

              //Construct a new logged in user object
              //Transfer some db data to the session object
              $loggedInUser = new \Model\LoggedInUser($context);
              $loggedInUser->email = $userdetails["email"];
              $loggedInUser->user_id = $userdetails["id"];
              $loggedInUser->hash_pw = $userdetails["password"];
              $loggedInUser->title = $userdetails["title"];
              $loggedInUser->displayname = $userdetails["display_name"];
              $loggedInUser->username = $userdetails["user_name"];

              //Update last sign in
              $loggedInUser->updateLastSignIn();
              $context->getRequest()->setLoggedInUser($loggedInUser);

              //Redirect to user account page
              header("Location: /account");
              die();
            }
          }
        }
      }
    }
    return
      <login:page:view
        logged_in_user={$context->getRequest()->getLoggedInUser()}
        errors={$errors}
      />;
  }

}
