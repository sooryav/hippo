<?hh

namespace Model;

require_once(__DIR__. '/Util.php');

class LoggedInUser {
  public $email = null;
  public $hash_pw = null;
  public $user_id = null;
  public $title = null;
  public $displayname = null;
  public $username = null;
  private $m_context = null;

  public function __construct(\Core\Context $context) {
    $this->m_context = $context;
  }

  //Simple function to update the last sign in of a user
  public function updateLastSignIn() {
    $mysqli = $this->m_context->getDBConnection();
    $db_table_prefix = $this->m_context->getDBTablePrefix();
    $time = time();
    $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
      SET
      last_sign_in_stamp = ?
      WHERE
      id = ?");
    $stmt->bind_param("ii", $time, $this->user_id);
    $stmt->execute();
    $stmt->close();
  }

  //Return the timestamp when the user registered
  public function signupTimeStamp() {
    $mysqli = $this->m_context->getDBConnection();
    $db_table_prefix = $this->m_context->getDBTablePrefix();
    $timestamp = time();
    $stmt = $mysqli->prepare("SELECT sign_up_stamp
      FROM ".$db_table_prefix."users
      WHERE id = ?");
    $stmt->bind_param("i", $this->user_id);
    $stmt->execute();
    $stmt->bind_result($timestamp);
    $stmt->fetch();
    $stmt->close();
    return ($timestamp);
  }

  //Update a users password
  public function updatePassword($pass) {
    $mysqli = $this->m_context->getDBConnection();
    $db_table_prefix = $this->m_context->getDBTablePrefix();
    $secure_pass = generateHash($pass);
    $this->hash_pw = $secure_pass;
    $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
      SET
      password = ?
      WHERE
      id = ?");
    $stmt->bind_param("si", $secure_pass, $this->user_id);
    $stmt->execute();
    $stmt->close();
  }

  //Update a users email
  public function updateEmail($email) {
    $mysqli = $this->m_context->getDBConnection();
    $db_table_prefix = $this->m_context->getDBTablePrefix();
    $this->email = $email;
    $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
      SET
      email = ?
      WHERE
      id = ?");
    $stmt->bind_param("si", $email, $this->user_id);
    $stmt->execute();
    $stmt->close();
  }

  //Is a user has a permission
  public function checkPermission($permission) {
    $mysqli = $this->m_context->getDBConnection();
    $db_table_prefix = \Core\Context::DB_TABLE_PREFIX;
    $master_account = \Core\Context::MASTER_ACCOUNT;
    //Grant access if master user

    $stmt = $mysqli->prepare("SELECT id
      FROM ".$db_table_prefix."user_permission_matches
      WHERE user_id = ?
      AND permission_id = ?
      LIMIT 1
      ");
    $access = 0;
    foreach ($permission as $check) {
      if ($access == 0){
        $stmt->bind_param("ii", $this->user_id, $check);
        $stmt->execute();
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
          $access = 1;
        }
      }
    }
    if ($access == 1) {
      return true;
    }
    if ($this->user_id == $master_account) {
      return true;
    } else {
      return false;
    }
    //$stmt->close();
  }

  //Logout
  public function userLogOut() {
    Util::destroySession("userCakeUser");
  }
}
