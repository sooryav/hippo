<?hh

require_once(__DIR__ . '/../../model/Util.php');
require_once(__DIR__ . '/XPageView.php');
require_once(__DIR__ . '/LeftNavView.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');

class :register:user:page:view extends :x:page:view {
  attribute
    \Model\LoggedInUser logged_in_user = null,
    array errors = array(),
    array successes = array();

  <<Override>>
  public function getBody(): :x:frag {
    return
      <x:frag>
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
                <form class="form-horizontal" name="newUser" action={"/register_user"} method="post">
                  <div class="form-group">
                    <label class="control-label">User Name</label>
                    <input class="form-control" type="text" name="username" />
                  </div>
                  <div class="form-group">
                    <label class="control-label">Display Name</label>
                    <input class="form-control" type="text" name="displayname" />
                  </div>
                  <div class="form-group">
                    <label class="control-label">Password</label>
                    <input class="form-control" type="password" name="password" />
                  </div>
                  <div class="form-group">
                    <label class="control-label">Confirm</label>
                    <input class="form-control" type="password" name="passwordc" />
                  </div>
                  <div class="form-group">
                    <label class="control-label">Email</label>
                    <input class="form-control" type="text" name="email" />
                  </div>
                  <button type="submit" class="btn btn-lg btn-success">Register</button>
                </form>
              </div>
            </div>
          </td>
          </tr></table>
        </div>
      </x:frag>;

  }

}
