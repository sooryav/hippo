<?hh

require_once(__DIR__ . '/../../model/Util.php');
require_once(__DIR__ . '/XPageView.php');
require_once(__DIR__ . '/LeftNavView.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');

class :header:view extends :x:element {

  <<Override>>
  public function render(): :x:frag {
    return
      <x:frag>
      <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="navbar-header" style="padding-left:40%">
          <h1>
            <a href={"/home"}><b>Hippo</b></a>
          </h1>
        </div>
      </nav>
      </x:frag>;

  }

}
