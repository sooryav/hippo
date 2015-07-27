<?hh

require_once(__DIR__ . '/../../model/Util.php');
require_once(__DIR__ . '/XPageView.php');
require_once(__DIR__ . '/LeftNavView.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');

class :home:page:view extends :x:page:view {
  attribute
    \Model\LoggedInUser logged_in_user = null;

  <<Override>>
  public function getBody(): :x:frag {
    $loggedInUser = $this->getAttribute('logged_in_user');
    $msg = '';
    if ($loggedInUser) {
      $msg = "Hello " . $loggedInUser->displayname . "! ";
    }
    $msg = $msg . "Welcome to Hippo! Start Planning your event!";
    $signupButton = null;
    $loginButton = null;
    if (!$loggedInUser) {
      $signupButton =
        <button
          type="button"
          onclick="location.href='/register_user';"
          class="btn btn-sm btn-primary">
            {"SignUp"}
        </button>;
      $loginButton =
        <button
          type="button"
          onclick="location.href='/login';"
          style="margin-left:2%"
          class="btn btn-sm btn-success">
            {"Login"}
        </button>;
    }
    return
      <x:frag>
        <div style="padding-top:10%">
          <br />
          <table><tr>
          <td style="margin-right:20%;vertical-align:top;">
            <left-nav:view logged_in_user={$this->getAttribute('logged_in_user')}/>
          </td>
          <td style="margin-left:20%">
            <div id="main" style="margin-left:20%;width:100%">
              <p class="jumbotron">
                {$msg}
              </p>
              <p style="margin-top:1%">
                {$signupButton}
                {$loginButton}
              </p>
            </div>
          </td>
          </tr></table>
        </div>
      </x:frag>;

  }

}
