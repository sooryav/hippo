<?hh

require_once(__DIR__ . '/../../model/Util.php');
require_once(__DIR__ . '/XPageView.php');
require_once(__DIR__ . '/LeftNavView.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');

class :login:page:view extends :x:page:view {
  attribute
    \Model\LoggedInUser logged_in_user = null,
    array errors = array(),
    array successes = array();

  <<Override>>
  public function getBody(): :x:frag {
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
              <left-nav:view logged_in_user={$this->getAttribute('logged_in_user')}/>
            </td>
            <td style="padding-left:20%">
              <div id="main">
                {\Model\Util::resultBlock(
                  $this->getAttribute('errors'),
                  $this->getAttribute('successes')
                )}
                <div id="regbox">
                  <form name="login" action={"/login"} method="post">
                    <div class="form-group">
                      <label class="control-label">Username</label>
                      <input class="form-control" type="text" name="username" />
                    </div>
                    <div class="form-group">
                      <label class="control-label">Password</label>
                      <input class="form-control" type="password" name="password" />
                    </div>
                    <button type="submit" class="btn btn-lg btn-success">Login</button>
                  </form>
                </div>
              </div>
            </td>
            </tr></table>
          </div>
        </div>
        <div id="bottom" />
      </div>
    </x:frag>;
  }

  public function getCSS() {
    return __DIR__ . '/../css/login.css';
  }

  public function getJS() {
    return __DIR__ . '/../js/login.js';
  }

}
