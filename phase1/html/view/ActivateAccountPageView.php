<?hh

require_once(__DIR__ . '/../../model/Util.php');
require_once(__DIR__ . '/XPageView.php');
require_once(__DIR__ . '/LeftNavView.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');

class :activate:account:page:view extends :x:page:view {
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
          <td style="margin-left:20%">
            <div id="main" style="margin-left:20%;width:100%">
              {\Model\Util::resultBlock(
                $this->getAttribute('errors'),
                $this->getAttribute('successes')
              )}
            </div>
          </td>
          </tr></table>
        </div>
      </x:frag>;

  }

}
