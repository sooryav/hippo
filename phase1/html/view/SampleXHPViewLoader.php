<?hh

require_once('XPageView.php');
require_once('/var/www/vendor/autoload.php');

class SampleXHPView extends XPageView {

  public function getBody() {
    return
      <x:frag>
        <bootstrap:alert use="success">
          You rock
        </bootstrap:alert>
        <bootstrap:alert use="info">
          Maybe you rock
        </bootstrap:alert>
        <bootstrap:alert use="warning">
          WAT??
        </bootstrap:alert>
        <bootstrap:alert use="danger">
          May day May day
          <a href="https://somewhere.com">Go here</a>
        </bootstrap:alert>
      </x:frag>;
  }

}

$s = new SampleXHPView();
echo $s->render();
