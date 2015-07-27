<?hh

require_once(__DIR__ . '/../../model/Util.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');

class :left-nav:view extends :x:element {
  attribute
    \Core\Context context = null,
    \Model\LoggedInUser user = null;

  public function render() {
    $context = $this->getAttribute('context');
    if (!\Model\Util::securePage($context, $_SERVER['PHP_SELF'])) {
      die();
    }

    $view = <div id="left-nav"/>;
    //Links for logged in user
    if(\Model\Util::isUserLoggedIn($context)) {
      $view->appendChild(
        <ul class="list-unstyled">
          <li><a href="/account">Account Home</a></li>
          <li><a href="/user_settings">User Settings</a></li>
          <li><a href="/logout">Logout</a></li>
        </ul>
      );
      //Links for permission level 2 (default admin)
      if ($context->getLoggedInUser()->checkPermission(array(2))){
        $view->appendChild(
          <ul class="list-unstyled">
            <li><a href="/admin_configuration">Admin Configuration</a></li>
            <li><a href="/admin_users">Admin Users</a></li>
            <li><a href="/admin_permissions">Admin Permissions</a></li>
            <li><a href="/admin_pages">Admin Pages</a></li>
          </ul>
        );
      }
    } else {
      //Links for users not logged in
      $resendActivation =
        \Core\Context::EMAIL_ACTIVATION ?
        <li><a href="/resend-activation">Resend Activation Email</a></li> :
        null;
      $view->appendChild(
        <ul class="list-unstyled">
          <li><a href="/home">Home</a></li>
          <li><a href="/login">Login</a></li>
          <li><a href="/register_user">Register</a></li>
          <li><a href="/forgot_password">Forgot Password</a></li>
          {$resendActivation}
        </ul>
      );
    }
    return $view;
  }
}
