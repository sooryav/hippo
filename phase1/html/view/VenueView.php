<?hh

require_once(__DIR__ . '/XPageView.php');
require_once(__DIR__ . '/lib/composer/vendor/autoload.php');

class :ui:venues:view extends :x:page:view {

  attribute int totalVenuesCount @required;

  <<Override>>
  public function getBody(): :x:frag {
    return
      <x:frag>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js" />
        <script src="../javascript/vendor.js" />
        <div id="results"></div>
        <button class="load_more" id="load_more_button">load More</button>
        <div class="animation_image" style="display:none;">Loading...</div>
        <div id="totalVenuesCount" style="display:none;">
          { $this->getAttribute('totalVenuesCount') }
        </div>
      </x:frag>;
  }

}
