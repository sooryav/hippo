<?hh

namespace Model;

require_once(__DIR__ . '/../entity/Venue.php');

use Entity\Venue;

class VenueModel {

  private Vector<Venue> $m_venues;

  public function __construct() {
    $this->m_venues = Vector{
      new Venue('venue1', '98006'),
      new Venue('venue2', '98006'),
    };
  }

  public function getVenues(): Vector<Venue> {
    return $this->m_venues;
  }

  public function getTotalVenuesCount(): int {
    // TODO: Need to simluate better. This is just for testing now. 
    return 5;
  }

}

