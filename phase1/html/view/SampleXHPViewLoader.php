<?hh

require_once('XPageView.php');
require_once('lib/composer/vendor/autoload.php');

class :sample:xhp:view extends :x:page:view {

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

echo <sample:xhp:view />;
