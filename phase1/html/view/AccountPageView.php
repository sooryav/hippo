<?hh

require_once(__DIR__ . '/../../model/Util.php');
require_once(__DIR__ . '/../../model/LoggedInUser.php');
require_once(__DIR__ . '/XPageView.php');
require_once(__DIR__ . '/LeftNavView.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');

class :account:page:view extends :x:page:view {
  attribute
    \Model\LoggedInUser logged_in_user = null;

  <<Override>>
  public function getBody(): :x:frag {
    $loggedInUser = $this->getAttribute('logged_in_user');
    $msg = null;
    if ($loggedInUser) {
      $msg = "Hey, " .
        $loggedInUser->displayname .
        ". Your title at the moment is " . $loggedInUser->title .
        ". You registered this account on " .
        date("m/d/y", $loggedInUser->signupTimeStamp());
    }
    return
      <x:frag>
        <div style="padding-top:10%">
          <br />
          <table><tr>
          <td style="margin-right:20%;vertical-align:top;">
            <left-nav:view logged_in_user={$loggedInUser}/>
          </td>
          <td style="padding-left:20%">
            <div id="main">
              {$msg}
            </div>
          </td>
          </tr></table>
        </div>
      </x:frag>;

  }

}
