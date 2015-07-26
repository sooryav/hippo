<?hh

require_once(__DIR__ . '/XPageView.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');

class :error:page:view extends :x:page:view {
  attribute
    Map<string,string> inputs = null;

  <<Override>>
  public function getBody(): :x:frag {
    $msg = $this->getAttribute('inputs')['message'];
    return
      <x:frag>
        <p>{$msg}</p>
      </x:frag>;
  }

}
