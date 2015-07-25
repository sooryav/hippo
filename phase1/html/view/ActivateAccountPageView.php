<?hh

require_once(__DIR__ . '/../../model/Util.php');
require_once(__DIR__ . '/XPageView.php');
require_once(__DIR__ . '/LeftNavView.php');
require_once(__DIR__ . '/lib/composer/vendor/autoload.php');

class :activate:account:page:view extends :x:page:view {
  attribute
    \Core\Context context = null,
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
              <left-nav:view context={$this->getAttribute('context')}/>
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
        </div>
        <div id="bottom" />
      </div>
    </x:frag>;

  }

}