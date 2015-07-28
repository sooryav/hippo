<?hh

namespace Model;

require_once(__DIR__ . '/../core/Context.php');
require_once(__DIR__ . '/../html/languages/en.php');
require_once(__DIR__ . '/../config/SiteConfig.php');

//Functions that do not interact with DB
//------------------------------------------------------------------------------
class Util {

  //Retrieve a list of all .php files in model/languages
  public static function getLanguageFiles() {
    $directory = __DIR__ . '/../html/languages/';
    $languages = glob($directory . '*.php');
    //print each file name
    return $languages;
  }

  //Retrieve a list of all .css files in models/site-templates
  public static function getTemplateFiles() {
    $directory = __DIR__ . '/../html/css/';
    $files = glob($directory . '*.css');
    //print each file name
    return $files;
  }

  //Retrieve a list of all .php files in root files folder
  public static function getPageFiles() {
    $directory = __DIR__ . '/../controller/';
    $pages = glob($directory . '*.php');
    //print each file name
    $row = array();
    foreach ($pages as $page) {
      $row[$page] = $page;
    }
    return $row;
  }

  //Destroys a session as part of logout
  public static function destroySession($name) {
    if(isset($_SESSION[$name])) {
      $_SESSION[$name] = NULL;
      unset($_SESSION[$name]);
    }
  }

  //Generate a unique code
  public static function getUniqueCode($length = "") {
    $code = md5(uniqid(rand(), true));
    if ($length != "") {
       return substr($code, 0, $length);
    } else {
      return $code;
    }
  }

  //Generate an activation key
  public static function generateActivationToken(\Core\Context $context, $gen = null) {
    do {
      $gen = md5(uniqid(mt_rand(), false));
    } while(self::validateActivationToken($context, $gen));
    return $gen;
  }

  //@ Thanks to - http://phpsec.org
  public static function generateHash($plainText, $salt = null) {
    if ($salt === null) {
      $salt = substr(md5(uniqid(rand(), true)), 0, 25);
    } else {
      $salt = substr($salt, 0, 25);
    }

    return $salt . sha1($salt . $plainText);
  }

  //Checks if an email is valid
  public static function isValidEmail($email) {
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
      return true;
    } else {
      return false;
    }
  }

  //Inputs language strings from selected language.
  public static function lang($key,$markers = NULL) {
    return $key;
    $lang = ErrorMessages::$lang;
    if($markers == NULL) {
      $str = $lang[$key];
    } else {
      //Replace any dyamic markers
      $str = $lang[$key];
      $iteration = 1;
      foreach($markers as $marker) {
        $str = str_replace("%m".$iteration."%",$marker,$str);
        $iteration++;
      }
    }
    //Ensure we have something to return
    if($str == "") {
      return "No language key found";
    } else {
      return $str;
    }
  }

  //Checks if a string is within a min and max length
  public static function minMaxRange($min, $max, $what) {
    if(strlen(trim($what)) < $min)
      return true;
    else if(strlen(trim($what)) > $max)
      return true;
    else
    return false;
  }

  //Displays error and success messages
  public static function resultBlock($errors,$successes) {
    //Error block
    $error_block = null;
    $success_block = null;
    if(count($errors) > 0) {
      $error_block = <div id="error" />;
      $error_block->appendChild(
        <a href="#">[X]</a>
      );
      $error_rows = <ul />;
      foreach($errors as $error) {
        $error_rows->appendChild(
          <li>{$error}</li>
        );
      }
    }
    //Success block
    if (count($successes) > 0) {
      $success_block = <div id="success" />;
      $success_block->appendChild(
        <a href="#">[X]</a>
      );
      $success_rows = <ul />;
      foreach($successes as $success) {
        $success_rows->appendChild(
          <li>{$success}</li>
        );
      }
    }
    return
      <div>
        {$error_block}
        {$success_block}
      </div>;
  }

  //Completely sanitizes text
  public static function sanitize($str) {
    return strtolower(strip_tags(trim(($str))));
  }

  //Functions that interact mainly with .users table
  //------------------------------------------------------------------------------

  //Delete a defined array of users
  public static function deleteUsers(\Core\Context $context, $users) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $i = 0;
    $stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."users
      WHERE id = ?");
    $stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches
      WHERE user_id = ?");
    foreach($users as $id) {
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $stmt2->bind_param("i", $id);
      $stmt2->execute();
      $i++;
    }
    $stmt->close();
    $stmt2->close();
    return $i;
  }

  //Check if a display name exists in the DB
  public static function displayNameExists(\Core\Context $context, $displayname) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("SELECT active
      FROM ".$db_table_prefix."users
      WHERE
      display_name = ?
      LIMIT 1");
    $stmt->bind_param("s", $displayname);
    $stmt->execute();
    $stmt->store_result();
    $num_returns = $stmt->num_rows;
    $stmt->close();

    if ($num_returns > 0) {
      return true;
    } else {
      return false;
    }
  }

  //Check if an email exists in the DB
  public static function emailExists(\Core\Context $context, $email) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("SELECT active
      FROM ".$db_table_prefix."users
      WHERE
      email = ?
      LIMIT 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    $num_returns = $stmt->num_rows;
    $stmt->close();

    if ($num_returns > 0) {
      return true;
    } else {
      return false;
    }
  }

  //Check if a user name and email belong to the same user
  public static function emailUsernameLinked(\Core\Context $context, $email,$username) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("SELECT active
      FROM ".$db_table_prefix."users
      WHERE user_name = ?
      AND
      email = ?
      LIMIT 1
      ");
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $stmt->store_result();
    $num_returns = $stmt->num_rows;
    $stmt->close();

    if ($num_returns > 0) {
      return true;
    } else {
      return false;
    }
  }

  //Retrieve information for all users
  public static function fetchAllUsers(\Core\Context $context) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("SELECT
      id,
      user_name,
      display_name,
      password,
      email,
      activation_token,
      last_activation_request,
      lost_password_request,
      active,
      title,
      sign_up_stamp,
      last_sign_in_stamp
      FROM ".$db_table_prefix."users");
    $stmt->execute();
    $id = null;
    $user = null;
    $display = null;
    $password = null;
    $email = null;
    $token = null;
    $activationRequest = null;
    $passwordRequest = null;
    $active = null;
    $title = null;
    $signUp = null;
    $signIn = null;
    $stmt->bind_result(
      $id,
      $user,
      $display,
      $password,
      $email,
      $token,
      $activationRequest,
      $passwordRequest,
      $active,
      $title,
      $signUp,
      $signIn
    );
    $row = array();
    while ($stmt->fetch()) {
      $row[] = array(
        'id' => $id,
        'user_name' => $user,
        'display_name' => $display,
        'password' => $password,
        'email' => $email,
        'activation_token' => $token,
        'last_activation_request' => $activationRequest,
        'lost_password_request' => $passwordRequest,
        'active' => $active,
        'title' => $title,
        'sign_up_stamp' => $signUp,
        'last_sign_in_stamp' => $signIn
      );
    }
    $stmt->close();
    return ($row);
  }

  //Retrieve complete user information by username, token or ID
  public static function fetchUserDetails(\Core\Context $context, $username=NULL,$token=NULL, $id=NULL) {
    $column = null;
    $data = null;
    if ($username != null) {
      $column = "user_name";
      $data = $username;
    } elseif ($token != null) {
      $column = "activation_token";
      $data = $token;
    } elseif($id != null) {
      $column = "id";
      $data = $id;
    }
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("SELECT
      id,
      user_name,
      display_name,
      password,
      email,
      activation_token,
      last_activation_request,
      lost_password_request,
      active,
      title,
      sign_up_stamp,
      last_sign_in_stamp
      FROM ".$db_table_prefix."users
      WHERE
      $column = ?
      LIMIT 1");
      $stmt->bind_param("s", $data);

    $stmt->execute();
    $id = null;
    $user = null;
    $display = null;
    $password = null;
    $email = null;
    $token = null;
    $activationRequest = null;
    $passwordRequest = null;
    $active = null;
    $title = null;
    $signUp = null;
    $signIn = null;
    $stmt->bind_result(
      $id,
      $user,
      $display,
      $password,
      $email,
      $token,
      $activationRequest,
      $passwordRequest,
      $active,
      $title,
      $signUp,
      $signIn
    );
    $row = array();
    while ($stmt->fetch()) {
      $row = array(
        'id' => $id,
        'user_name' => $user,
        'display_name' => $display,
        'password' => $password,
        'email' => $email,
        'activation_token' => $token,
        'last_activation_request' => $activationRequest,
        'lost_password_request' => $passwordRequest,
        'active' => $active,
        'title' => $title,
        'sign_up_stamp' => $signUp,
        'last_sign_in_stamp' => $signIn
      );
    }
    $stmt->close();
    return ($row);
  }

  //Toggle if lost password request flag on or off
  public static function flagLostPasswordRequest(\Core\Context $context, $username,$value) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
      SET lost_password_request = ?
      WHERE
      user_name = ?
      LIMIT 1
      ");
    $stmt->bind_param("ss", $value, $username);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  //Check if a user is logged in
  public static function isUserLoggedIn(\Core\Context $context) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $loggedInUser = $context->getRequest()->getLoggedInUser();
    $stmt = $mysqli->prepare("SELECT
      id,
      password
      FROM ".$db_table_prefix."users
      WHERE
      id = ?
      AND
      password = ?
      AND
      active = 1
      LIMIT 1");
    $stmt->bind_param("is", $loggedInUser->user_id, $loggedInUser->hash_pw);
    $stmt->execute();
    $stmt->store_result();
    $num_returns = $stmt->num_rows;
    $stmt->close();

    if($loggedInUser == NULL) {
      return false;
    } else {
      if ($num_returns > 0) {
        return true;
      } else {
        self::destroySession("userCakeUser");
        return false;
      }
    }
  }

  //Change a user from inactive to active
  public static function setUserActive(\Core\Context $context, $token) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
      SET active = 1
      WHERE
      activation_token = ?
      LIMIT 1");
    $stmt->bind_param("s", $token);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  //Change a user's display name
  public static function updateDisplayName(\Core\Context $context, $id, $display) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
      SET display_name = ?
      WHERE
      id = ?
      LIMIT 1");
    $stmt->bind_param("si", $display, $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  //Update a user's email
  public static function updateEmail(\Core\Context $context, $id, $email) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
      SET
      email = ?
      WHERE
      id = ?");
    $stmt->bind_param("si", $email, $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  //Input new activation token, and update the time of the most recent activation request
  public static function updateLastActivationRequest(\Core\Context $context, $new_activation_token,$username,$email) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
      SET activation_token = ?,
      last_activation_request = ?
      WHERE email = ?
      AND
      user_name = ?");
    $stmt->bind_param("ssss", $new_activation_token, time(), $email, $username);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  //Generate a random password, and new token
  public static function updatePasswordFromToken(\Core\Context $context, $pass,$token) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $new_activation_token = self::generateActivationToken($context);
    $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
      SET password = ?,
      activation_token = ?
      WHERE
      activation_token = ?");
    $stmt->bind_param("sss", $pass, $new_activation_token, $token);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  //Update a user's title
  public static function updateTitle(\Core\Context $context, $id, $title) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."users
      SET
      title = ?
      WHERE
      id = ?");
    $stmt->bind_param("si", $title, $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  //Check if a user ID exists in the DB
  public static function userIdExists(\Core\Context $context, $id) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("SELECT active
      FROM ".$db_table_prefix."users
      WHERE
      id = ?
      LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $num_returns = $stmt->num_rows;
    $stmt->close();

    if ($num_returns > 0) {
      return true;
    } else {
      return false;
    }
  }

  //Checks if a username exists in the DB
  public static function usernameExists(\Core\Context $context, $username) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("SELECT active
      FROM ".$db_table_prefix."users
      WHERE
      user_name = ?
      LIMIT 1");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $num_returns = $stmt->num_rows;
    $stmt->close();

    if ($num_returns > 0) {
      return true;
    } else {
      return false;
    }
  }

  //Check if activation token exists in DB
  public static function validateActivationToken(\Core\Context $context, $token, $lostpass=null) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    if($lostpass == NULL) {
      $stmt = $mysqli->prepare("SELECT active
        FROM ".$db_table_prefix."users
        WHERE active = 0
        AND
        activation_token = ?
        LIMIT 1");
    } else {
      $stmt = $mysqli->prepare("SELECT active
        FROM ".$db_table_prefix."users
        WHERE active = 1
        AND
        activation_token = ?
        AND
        lost_password_request = 1
        LIMIT 1");
    }
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $stmt->store_result();
      $num_returns = $stmt->num_rows;
    $stmt->close();

    if ($num_returns > 0) {
      return true;
    } else {
      return false;
    }
  }

  //Functions that interact mainly with .permissions table
  //------------------------------------------------------------------------------

  //Create a permission level in DB
  public static function createPermission(\Core\Context $context, $permission) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."permissions (
      name
      )
      VALUES (
      ?
      )");
    $stmt->bind_param("s", $permission);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  //Delete a permission level from the DB
  public static function deletePermission(\Core\Context $context, $permission) : array {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $i = 0;
    $errors = array();
    $stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permissions
      WHERE id = ?");
    $stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches
      WHERE permission_id = ?");
    $stmt3 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches
      WHERE permission_id = ?");
    foreach ($permission as $id) {
      if ($id == 1) {
        $errors[] = self::lang("CANNOT_DELETE_NEWUSERS");
      } elseif ($id == 2) {
        $errors[] = self::lang("CANNOT_DELETE_ADMIN");
      } else{
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt2->bind_param("i", $id);
        $stmt2->execute();
        $stmt3->bind_param("i", $id);
        $stmt3->execute();
        $i++;
      }
    }
    $stmt->close();
    $stmt2->close();
    $stmt3->close();
    return $errors;
  }

  //Retrieve information for all permission levels
  public static function fetchAllPermissions(\Core\Context $context) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("SELECT
      id,
      name
      FROM ".$db_table_prefix."permissions");
    $stmt->execute();
    $id = null;
    $name = null;
    $stmt->bind_result($id, $name);
    $row = array();
    while ($stmt->fetch()) {
      $row[] = array('id' => $id, 'name' => $name);
    }
    $stmt->close();
    return ($row);
  }

  //Retrieve information for a single permission level
  public static function fetchPermissionDetails(\Core\Context $context, $id) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("SELECT
      id,
      name
      FROM ".$db_table_prefix."permissions
      WHERE
      id = ?
      LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $id = null;
    $name = null;
    $stmt->bind_result($id, $name);
    $row = array();
    while ($stmt->fetch()) {
      $row = array('id' => $id, 'name' => $name);
    }
    $stmt->close();
    return ($row);
  }

  //Check if a permission level ID exists in the DB
  public static function permissionIdExists(\Core\Context $context, $id) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("SELECT id
      FROM ".$db_table_prefix."permissions
      WHERE
      id = ?
      LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $num_returns = $stmt->num_rows;
    $stmt->close();

    if ($num_returns > 0) {
      return true;
    } else {
      return false;
    }
  }

  //Check if a permission level name exists in the DB
  public static function permissionNameExists(\Core\Context $context, $permission) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("SELECT id
      FROM ".$db_table_prefix."permissions
      WHERE
      name = ?
      LIMIT 1");
    $stmt->bind_param("s", $permission);
    $stmt->execute();
    $stmt->store_result();
    $num_returns = $stmt->num_rows;
    $stmt->close();

    if ($num_returns > 0) {
      return true;
    } else {
      return false;
    }
  }

  //Change a permission level's name
  public static function updatePermissionName(\Core\Context $context, $id, $name) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."permissions
      SET name = ?
      WHERE
      id = ?
      LIMIT 1");
    $stmt->bind_param("si", $name, $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  //Functions that interact mainly with .user_permission_matches table
  //------------------------------------------------------------------------------

  //Match permission level(s) with user(s)
  public static function addPermission(\Core\Context $context, $permission, $user) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $i = 0;
    $stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."user_permission_matches (
      permission_id,
      user_id
      )
      VALUES (
      ?,
      ?
      )");
    if (is_array($permission)) {
      foreach($permission as $id) {
        $stmt->bind_param("ii", $id, $user);
        $stmt->execute();
        $i++;
      }
    } elseif (is_array($user)) {
      foreach($user as $id) {
        $stmt->bind_param("ii", $permission, $id);
        $stmt->execute();
        $i++;
      }
    } else {
      $stmt->bind_param("ii", $permission, $user);
      $stmt->execute();
      $i++;
    }
    $stmt->close();
    return $i;
  }

  //Retrieve information for all user/permission level matches
  public static function fetchAllMatches(\Core\Context $context) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("SELECT
      id,
      user_id,
      permission_id
      FROM ".$db_table_prefix."user_permission_matches");
    $stmt->execute();
    $id = null;
    $user = null;
    $permission = null;
    $stmt->bind_result($id, $user, $permission);
    $row = array();
    while ($stmt->fetch()) {
      $row[] = array('id' => $id, 'user_id' => $user, 'permission_id' => $permission);
    }
    $stmt->close();
    return ($row);
  }

  //Retrieve list of permission levels a user has
  public static function fetchUserPermissions(\Core\Context $context, $user_id) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("SELECT
      id,
      permission_id
      FROM ".$db_table_prefix."user_permission_matches
      WHERE user_id = ?
      ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $id = null;
    $permission = null;
    $stmt->bind_result($id, $permission);
    $row = array();
    while ($stmt->fetch()) {
      $row[$permission] = array('id' => $id, 'permission_id' => $permission);
    }
    $stmt->close();
    if (isset($row)) {
      return ($row);
    }
  }

  //Retrieve list of users who have a permission level
  public static function fetchPermissionUsers(\Core\Context $context, $permission_id) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("SELECT id, user_id
      FROM ".$db_table_prefix."user_permission_matches
      WHERE permission_id = ?
      ");
    $stmt->bind_param("i", $permission_id);
    $stmt->execute();
    $id = null;
    $user = null;
    $stmt->bind_result($id, $user);
    $row = array();
    while ($stmt->fetch()) {
      $row[$user] = array('id' => $id, 'user_id' => $user);
    }
    $stmt->close();
    if (isset($row)) {
      return ($row);
    }
  }

  //Unmatch permission level(s) from user(s)
  public static function removePermission(\Core\Context $context, $permission, $user) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $i = 0;
    $stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."user_permission_matches
      WHERE permission_id = ?
      AND user_id =?");
    if (is_array($permission)) {
      foreach($permission as $id) {
        $stmt->bind_param("ii", $id, $user);
        $stmt->execute();
        $i++;
      }
    } elseif (is_array($user)) {
      foreach($user as $id) {
        $stmt->bind_param("ii", $permission, $id);
        $stmt->execute();
        $i++;
      }
    } else {
      $stmt->bind_param("ii", $permission, $user);
      $stmt->execute();
      $i++;
    }
    $stmt->close();
    return $i;
  }

  //Functions that interact mainly with .configuration table
  //------------------------------------------------------------------------------

  //Update configuration table
  public static function updateConfig(\Core\Context $context, $id, $value) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."configuration
      SET
      value = ?
      WHERE
      id = ?");
    foreach ($id as $cfg) {
      $stmt->bind_param("si", $value[$cfg], $cfg);
      $stmt->execute();
    }
    $stmt->close();
  }

  //Functions that interact mainly with .pages table
  //------------------------------------------------------------------------------

  //Add a page to the DB
  public static function createPages(\Core\Context $context, $pages) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."pages (
      page
      )
      VALUES (
      ?
      )");
    foreach($pages as $page) {
      $stmt->bind_param("s", $page);
      $stmt->execute();
    }
    $stmt->close();
  }

  //Delete a page from the DB
  public static function deletePages(\Core\Context $context, $pages) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."pages
      WHERE id = ?");
    $stmt2 = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches
      WHERE page_id = ?");
    foreach($pages as $id) {
      $stmt->bind_param("i", $id);
      $stmt->execute();
      $stmt2->bind_param("i", $id);
      $stmt2->execute();
    }
    $stmt->close();
    $stmt2->close();
  }

  //Fetch information on all pages
  public static function fetchAllPages(\Core\Context $context) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("SELECT
      id,
      page,
      private
      FROM ".$db_table_prefix."pages");
    $stmt->execute();
    $id = null;
    $page = null;
    $private = null;
    $stmt->bind_result($id, $page, $private);
    $row = array();
    while ($stmt->fetch()) {
      $row[$page] = array('id' => $id, 'page' => $page, 'private' => $private);
    }
    $stmt->close();
    if (isset($row)) {
      return ($row);
    }
  }

  //Fetch information for a specific page
  public static function fetchPageDetails(\Core\Context $context, $id) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("SELECT
      id,
      page,
      private
      FROM ".$db_table_prefix."pages
      WHERE
      id = ?
      LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $id = null;
    $page = null;
    $private = null;
    $stmt->bind_result($id, $page, $private);
    $row = array();
    while ($stmt->fetch()) {
      $row = array('id' => $id, 'page' => $page, 'private' => $private);
    }
    $stmt->close();
    return ($row);
  }

  //Check if a page ID exists
  public static function pageIdExists(\Core\Context $context, $id) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("SELECT private
      FROM ".$db_table_prefix."pages
      WHERE
      id = ?
      LIMIT 1");
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->store_result();
    $num_returns = $stmt->num_rows;
    $stmt->close();

    if ($num_returns > 0) {
      return true;
    } else {
      return false;
    }
  }

  //Toggle private/public setting of a page
  public static function updatePrivate(\Core\Context $context, $id, $private) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("UPDATE ".$db_table_prefix."pages
      SET
      private = ?
      WHERE
      id = ?");
    $stmt->bind_param("ii", $private, $id);
    $result = $stmt->execute();
    $stmt->close();
    return $result;
  }

  //Functions that interact mainly with .permission_page_matches table
  //------------------------------------------------------------------------------

  //Match permission level(s) with page(s)
  public static function addPage(\Core\Context $context, $page, $permission) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $i = 0;
    $stmt = $mysqli->prepare("INSERT INTO ".$db_table_prefix."permission_page_matches (
      permission_id,
      page_id
      )
      VALUES (
      ?,
      ?
      )");
    if (is_array($permission)) {
      foreach($permission as $id) {
        $stmt->bind_param("ii", $id, $page);
        $stmt->execute();
        $i++;
      }
    } elseif (is_array($page)) {
      foreach($page as $id) {
        $stmt->bind_param("ii", $permission, $id);
        $stmt->execute();
        $i++;
      }
    } else {
      $stmt->bind_param("ii", $permission, $page);
      $stmt->execute();
      $i++;
    }
    $stmt->close();
    return $i;
  }

  //Retrieve list of permission levels that can access a page
  public static function fetchPagePermissions(\Core\Context $context, $page_id) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("SELECT
      id,
      permission_id
      FROM ".$db_table_prefix."permission_page_matches
      WHERE page_id = ?
      ");
    $stmt->bind_param("i", $page_id);
    $stmt->execute();
    $id = null;
    $permission = null;
    $stmt->bind_result($id, $permission);
    $row = array();
    while ($stmt->fetch()) {
      $row[$permission] = array('id' => $id, 'permission_id' => $permission);
    }
    $stmt->close();
    if (isset($row)) {
      return ($row);
    }
  }

  //Retrieve list of pages that a permission level can access
  public static function fetchPermissionPages(\Core\Context $context, $permission_id) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $stmt = $mysqli->prepare("SELECT
      id,
      page_id
      FROM ".$db_table_prefix."permission_page_matches
      WHERE permission_id = ?
      ");
    $stmt->bind_param("i", $permission_id);
    $stmt->execute();
    $id = null;
    $page = null;
    $stmt->bind_result($id, $page);
    $row = array();
    while ($stmt->fetch()) {
      $row[$page] = array('id' => $id, 'permission_id' => $page);
    }
    $stmt->close();
    if (isset($row)) {
      return ($row);
    }
  }

  //Unmatched permission and page
  public static function removePage(\Core\Context $context, $page, $permission) {
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $i = 0;
    $stmt = $mysqli->prepare("DELETE FROM ".$db_table_prefix."permission_page_matches
      WHERE page_id = ?
      AND permission_id =?");
    if (is_array($page)) {
      foreach($page as $id) {
        $stmt->bind_param("ii", $id, $permission);
        $stmt->execute();
        $i++;
      }
    } elseif (is_array($permission)) {
      foreach($permission as $id) {
        $stmt->bind_param("ii", $page, $id);
        $stmt->execute();
        $i++;
      }
    } else {
      $stmt->bind_param("ii", $permission, $page);
      $stmt->execute();
      $i++;
    }
    $stmt->close();
    return $i;
  }

  //Check if a user has access to a page
  public static function securePage(\Core\Context $context, $uri) {
    //Separate document name from uri
    $tokens = explode('/', $uri);
    $page = $tokens[count($tokens)-1];
    $mysqli = $context->getDBConnection();
    $db_table_prefix = \Model\DatabaseHandler::getDBTablePrefix();
    $loggedInUser = $context->getRequest()->getLoggedInUser();
    //retrieve page details
    $stmt = $mysqli->prepare("SELECT
      id,
      page,
      private
      FROM ".$db_table_prefix."pages
      WHERE
      page = ?
      LIMIT 1");
    $stmt->bind_param("s", $page);
    $stmt->execute();
    $id = null;
    $page = null;
    $private = null;
    $stmt->bind_result($id, $page, $private);
    $pageDetails = array();
    while ($stmt->fetch()) {
      $pageDetails = array('id' => $id, 'page' => $page, 'private' => $private);
    }
    $stmt->close();
    //If page does not exist in DB, allow access
    if (empty($pageDetails)) {
      return true;
    } elseif ($pageDetails['private'] == 0) {
      //If page is public, allow access
      return true;
    } elseif(!self::isUserLoggedIn($context)) {
      //If user is not logged in, deny access
      header("Location: login.php");
      return false;
    } else {
      //Retrieve list of permission levels with access to page
      $stmt = $mysqli->prepare("SELECT
        permission_id
        FROM ".$db_table_prefix."permission_page_matches
        WHERE page_id = ?
        ");
      $stmt->bind_param("i", $pageDetails['id']);
      $stmt->execute();
      $id = null;
      $permission = null;
      $stmt->bind_result($permission);
      $pagePermissions = array();
      while ($stmt->fetch()) {
        $pagePermissions[] = $permission;
      }
      $stmt->close();
      //Check if user's permission levels allow access to page
      if ($loggedInUser->checkPermission($pagePermissions)) {
        return true;
      } elseif ($loggedInUser->user_id == \Config\SiteConfig::MASTER_ACCOUNT) {
        //Grant access if master user
        return true;
      } else {
        header("Location: account.php");
        return false;
      }
    }
}

}
