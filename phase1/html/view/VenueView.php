<?hh

require_once(__DIR__ . '/XPageView.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');

class :ui:venues:view extends :x:page:view {

  // TODO: This may not be the best way to communicate
  // to the client. Come up with something else?
  attribute int totalVenuesCount @required;

  <<Override>>
  public function getBody(): :x:frag {
    return
      <x:frag>
        <script src="../js/vendor.js" />
        <bootstrap:root>
          <bootstrap:container>
            <bootstrap:container id="results" />
            <bootstrap:button use="primary" id="load_button">Load More</bootstrap:button>
          </bootstrap:container>
        </bootstrap:root>

        <div id="totalVenuesCount" class="hidden">
          { $this->getAttribute('totalVenuesCount') }
        </div>
      </x:frag>;
  }

}
