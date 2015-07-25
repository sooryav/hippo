<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../model/Util.php');
require_once(__DIR__ . '/../model/User.php');
require_once(__DIR__ . '/../html/view/RegisterUserPageView.php');
require_once(__DIR__ . '/../core/Context.php');

class RegisterUserController extends ControllerBase {

  public function __construct(\Core\Context $context, Map<string, string> $inputs) {
    parent::__construct(get_class($this), '/register_user', $context, $inputs);
  }

  <<Override>>
  public function render(): :x:element {

    $context = $this->getContext();

    if (!\Model\Util::securePage($context, $_SERVER['PHP_SELF'])){
      die();
    }

    //Prevent the user visiting the logged in page if he/she is already logged in
    if (\Model\Util::isUserLoggedIn($context)) {
      header('Location: /account');
      die();
    }

    $errors = array();
    $successes = array();
    $user = null;
    if (!empty($_POST)) {
      $email = trim($_POST["email"]);
      $username = trim($_POST["username"]);
      $displayname = trim($_POST["displayname"]);
      $password = trim($_POST["password"]);
      $confirm_pass = trim($_POST["passwordc"]);
      // $captcha = md5($_POST["captcha"]);

      // if ($captcha != $_SESSION['captcha']) {
      //   $errors[] = \Model\Util::lang("CAPTCHA_FAIL");
      // }
      if (\Model\Util::minMaxRange(5,25,$username)) {
        $errors[] = \Model\Util::lang("ACCOUNT_USER_CHAR_LIMIT",array(5,25));
      }
      if (!ctype_alnum($username)) {
        $errors[] = \Model\Util::lang("ACCOUNT_USER_INVALID_CHARACTERS");
      }
      if (\Model\Util::minMaxRange(5,25,$displayname)) {
        $errors[] = \Model\Util::lang("ACCOUNT_DISPLAY_CHAR_LIMIT",array(5,25));
      }
      if (!ctype_alnum($displayname)) {
        $errors[] = \Model\Util::lang("ACCOUNT_DISPLAY_INVALID_CHARACTERS");
      }
      if (\Model\Util::minMaxRange(8,50,$password) && \Model\Util::minMaxRange(8,50,$confirm_pass)) {
        $errors[] = \Model\Util::lang("ACCOUNT_PASS_CHAR_LIMIT",array(8,50));
      } else if($password != $confirm_pass) {
        $errors[] = \Model\Util::lang("ACCOUNT_PASS_MISMATCH");
      }
      if (!\Model\Util::isValidEmail($email)) {
        $errors[] = \Model\Util::lang("ACCOUNT_INVALID_EMAIL");
      }
      //End data validation
      if (count($errors) == 0) {
        //Construct a user object
        $user = new \Model\User($context, $username, $displayname, $password, $email);

        //Checking this flag tells us whether there were any errors such as possible data duplication occured
        if (!$user->status) {
          if ($user->username_taken) {
            $errors[] = \Model\Util::lang("ACCOUNT_USERNAME_IN_USE",array($username));
          }
          if ($user->displayname_taken) {
            $errors[] = \Model\Util::lang("ACCOUNT_DISPLAYNAME_IN_USE",array($displayname));
          }
          if ($user->email_taken) {
            $errors[] = \Model\Util::lang("ACCOUNT_EMAIL_IN_USE",array($email));
          }
        } else {
          //Attempt to add the user to the database, carry out finishing  tasks like emailing the user (if required)
          if (!$user->addUser()) {
            if ($user->mail_failure) {
              $errors[] = \Model\Util::lang("MAIL_ERROR");
            }
            if ($user->sql_failure) {
              $errors[] = \Model\Util::lang("SQL_ERROR");
            }
          }
        }
      }
      if (count($errors) == 0 && $user != null) {
        $successes[] = $user->success;
      }
    }

    return
      <register:user:page:view
        context={$context}
        errors={$errors}
        successes={$successes}
       />;

  }

}
