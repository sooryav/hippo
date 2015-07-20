<?hh

require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');
require_once(__DIR__ . '/../../entity/Venue.php');

use Entity\Venue;

class :ui:venue-list extends :x:element {

  attribute :ul;
  attribute Vector<Venue> venues @required;
  attribute bool createContainer = true;

  public function render() {
    $venues = $this->getAttribute('venues');
    $createContainer = $this->getAttribute('createContainer');
    $id = $this->getAttribute('id');

    $venueList = $createContainer
      ? <bootstrap:list-group id={$id}/>
      : <x:frag />;

    // TODO: Create a :ui:venue for displaying each venue.
    // I tried it but appendChild doesn't like adding :ui:venue
    // in place of list-group-item. Need more research.
    foreach ($venues as $venue) {
      $venueList->appendChild(
        <bootstrap:list-group-item>
          {$venue->m_name . ': ' . $venue->m_zip}
        </bootstrap:list-group-item>);
    }
    
    return $venueList;
  }

}

