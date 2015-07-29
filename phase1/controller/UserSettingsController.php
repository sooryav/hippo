<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../model/Util.php');
require_once(__DIR__ . '/../html/view/UserSettingsPageView.php');
require_once(__DIR__ . '/../core/Context.php');

class UserSettingsController extends ControllerBase {

  public function __construct(\Core\Context $context) {
    parent::__construct(get_class($this), '/user_settings', $context);
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

    $errors = array();
    $successes = array();
    if (!empty($_POST)) {
      $password = $_POST["password"];
      $password_new = $_POST["passwordc"];
      $password_confirm = $_POST["passwordcheck"];
      
      $email = $_POST["email"];
      $loggedInUser = $context->getRequest()->getLoggedInUser();
      
      //Perform some validation
      //Feel free to edit / change as required
      
      //Confirm the hashes match before updating a users password
      $entered_pass = \Model\Util::generateHash($password,$loggedInUser->hash_pw);
      
      if (trim($password) == "") {
        $errors[] = \Model\Util::lang("ACCOUNT_SPECIFY_PASSWORD");
      } else if ($entered_pass != $loggedInUser->hash_pw) {
        //No match
        $errors[] = \Model\Util::lang("ACCOUNT_PASSWORD_INVALID");
      }
      if ($email != $loggedInUser->email) {
        if (trim($email) == "") {
          $errors[] = \Model\Util::lang("ACCOUNT_SPECIFY_EMAIL");
        } else if (!\Model\Util::isValidEmail($email)) {
          $errors[] = \Model\Util::lang("ACCOUNT_INVALID_EMAIL");
        } else if (\Model\Util::emailExists($context, $email)) {
          $errors[] = \Model\Util::lang("ACCOUNT_EMAIL_IN_USE", array($email));
        } 
      
        //End data validation
        if (count($errors) == 0) {
          $loggedInUser->updateEmail($email);
          $successes[] = \Model\Util::lang("ACCOUNT_EMAIL_UPDATED");
        }  
      }
      
      if ($password_new != "" || $password_confirm != "") {
        if (trim($password_new) == "") {
          $errors[] = \Model\Util::lang("ACCOUNT_SPECIFY_NEW_PASSWORD");
        } else if (trim($password_confirm) == "") {
          $errors[] = \Model\Util::lang("ACCOUNT_SPECIFY_CONFIRM_PASSWORD");
        } else if (minMaxRange(8,50,$password_new)) {
          $errors[] = \Model\Util::lang("ACCOUNT_NEW_PASSWORD_LENGTH",array(8,50));
        } else if ($password_new != $password_confirm) {
          $errors[] = \Model\Util::lang("ACCOUNT_PASS_MISMATCH");
        }
      
        //End data validation
        if (count($errors) == 0) {
          //Also prevent updating if someone attempts to update with the same password
          $entered_pass_new = \Model\Util::generateHash($password_new,$loggedInUser->hash_pw);
      
          if ($entered_pass_new == $loggedInUser->hash_pw) {
            //Don't update, this fool is trying to update with the same password Â¬Â¬
            $errors[] = \Model\Util::lang("ACCOUNT_PASSWORD_NOTHING_TO_UPDATE");
          } else {
            //This function will create the new hash and update the hash_pw property.
            $loggedInUser->updatePassword($password_new);
            $successes[] = \Model\Util::lang("ACCOUNT_PASSWORD_UPDATED");
          }
        }
      }

      if (count($errors) == 0 && count($successes) == 0) {
        $errors[] = \Model\Util::lang("NOTHING_TO_UPDATE");
      }
    }
   
    return
      <user:settings:page:view
         logged_in_user={$context->getRequest()->getLoggedInUser()}
         errors={$errors}
         successes={$successes}
      />;
  }

}
