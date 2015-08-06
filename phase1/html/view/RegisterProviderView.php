<?hh

require_once(__DIR__ . '/../../model/Util.php');
require_once(__DIR__ . '/XPageView.php');
require_once(__DIR__ . '/LeftNavView.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');

class :register:provider:page:view extends :x:page:view {
  attribute
    string success = 'You rock',
    string info = 'Maybe you rock',
    string warning = 'WAT??',
    string danger = 'May day May day';


  <<Override>>
  public function getBody(): :x:frag {
    $body =
      <x:frag>
      </x:frag>;

      $body->appendChild($this->getProviderTypesDropdownBootstrap());

      return $body;
  }

  private function getProviderTypesDropdown(): XHPRoot {
    $providerTypeDropDown =
    <select>
      <option value="volvo">Volvo</option>
      <option value="saab">Saab</option>
      <option value="mercedes">Mercedes</option>
      <option value="audi">Audi</option>
    </select>;


    return $providerTypeDropDown;

  }

  private function getProviderTypesDropdownBootstrap(): XHPRoot {
    $providerTypeDropDown =

      <bootstrap:dropdown>
          <bootstrap:button>
            Dropdown
            <bootstrap:caret />
          </bootstrap:button>
          <bootstrap:dropdown:menu>
            <bootstrap:dropdown:item href="#">
              Foo
            </bootstrap:dropdown:item>
            <bootstrap:dropdown:item href="#">
              Bar
            </bootstrap:dropdown:item>

          </bootstrap:dropdown:menu>
        </bootstrap:dropdown>;

    return $providerTypeDropDown;

  }

}
