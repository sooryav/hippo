<?hh

require_once(__DIR__ . '/XPageView.php');
require_once(__DIR__ . '/../../core/RequestParams.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');

class :error:page:view extends :x:page:view {

  attribute
    \Core\RequestParams params @required;

  <<Override>>
  public function getBody(): :x:frag {
    $msg = $this->getAttribute('params')->getString('message');
    return
      <x:frag>
        <p>{$msg}</p>
      </x:frag>;
  }

}
