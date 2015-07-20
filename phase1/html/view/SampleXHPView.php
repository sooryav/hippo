<?hh

require_once(__DIR__ . '/XPageView.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');

class :sample:xhp:view extends :x:page:view {

  <<Override>>
  public function getBody(): :x:frag {
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
