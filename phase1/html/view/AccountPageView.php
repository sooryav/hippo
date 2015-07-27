<?hh

require_once(__DIR__ . '/../../model/Util.php');
require_once(__DIR__ . '/XPageView.php');
require_once(__DIR__ . '/LeftNavView.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');

class :account:page:view extends :x:page:view {
  attribute
    \Core\Context context = null,
    array errors = array(),
    array successes = array();

  <<Override>>
  public function getBody(): :x:frag {
    $loggedInUser = $this->getAttribute('context')->getLoggedInUser();
    $msg = "Hey, " .
    $loggedInUser->displayname .
    ". Your title at the moment is " . $loggedInUser->title .
    ". You registered this account on " .
    date("m/d/y", $loggedInUser->signupTimeStamp());
    return
    <x:frag>
      <div id="wrapper">
        <div id="top">
          <div id="logo"/>
        </div>
        <div id="content">
          <nav class="navbar navbar-inverse navbar-fixed-top">
            <div class="navbar-header" style="padding-left:40%">
            <h1>
              <a href={"/home"}><b>Hippo</b></a>
            </h1>
            </div>
          </nav>
          <div style="padding-top:10%">
            <br />
            <table><tr>
            <td style="margin-right:20%;vertical-align:top;">
              <left-nav:view context={$this->getAttribute('context')}/>
            </td>
            <td style="padding-left:20%">
              <div id="main">
                {$msg}
              </div>
            </td>
            </tr></table>
          </div>
        </div>
        <div id="bottom" />
      </div>
    </x:frag>;

  }

}
