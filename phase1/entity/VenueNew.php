<?hh

namespace Entity;

require_once(__DIR__ . '/ProviderNew.php');

class VenueNew extends ProviderNew {

  public function __construct(
   public string $m_providerId,
   public string $m_providerName,
   public string $m_providerDescription,
   public Vector<Contact> $m_contact,
   public ProviderType $m_providerType,
   public VenueType $m_venueType,
   public float $m_minimumPricePerBooking,
   public Vector<VenueFeatures> $m_venueFeatures,
   public Vector<VenueAmenities> $m_venueAmenities,
   public string $m_squareFootage,
   public int $m_maxOccupancy,
   public Vector<Address> $m_address) {
      parent::__construct(
        $m_providerId,
        $m_providerName,
        $m_providerDescription,
        $m_contact,
        $m_providerType,
        $m_address);

  }

  public function getaddress() : Vector<Address> {
    return $this->m_address;
  }

}
