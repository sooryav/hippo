<?hh

namespace Model;

require_once(__DIR__ . '/../entity/Venue.php');

use Entity\Venue;

class VenueModel {

  public function getVenues(): Vector<Venue> {
    $venues = Vector{
      new Venue('venue1', '98006'),
      new Venue('venue2', '98006'),
    };

    return $venues;
  }

}

