<?hh

require_once(__DIR__ . '/XPageView.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');

class :example:page:view extends :x:page:view {
  attribute
    string success = 'You rock',
    string info = 'Maybe you rock',
    string warning = 'WAT??',
    string danger = 'May day May day';

  <<Override>>
  public function getBody(): :x:frag {
    return
      <x:frag>
        <bootstrap:alert use="success">
          {$this->getAttribute('success')}
        </bootstrap:alert>
        <bootstrap:alert use="info">
          {$this->getAttribute('info')}
        </bootstrap:alert>
        <bootstrap:alert use="warning">
          {$this->getAttribute('warning')}
        </bootstrap:alert>
        <bootstrap:alert use="danger">
          {$this->getAttribute('danger')}
          <a href="https://somewhere.com">Go here</a>
        </bootstrap:alert>
      </x:frag>;
  }

}
