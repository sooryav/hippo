<?hh

namespace Entity;

require_once(__DIR__ . '/ProviderNew.php');

class VenueNew extends ProviderNew {

  public function __construct(
  public string $m_providerId,
  public string $m_providerName,
  public string $m_providerDescription,
  public Contact $m_contact,
  public ProviderType $m_providerType,
  public Address $m_address) {
      parent::__construct(
        $m_providerId,
        $m_providerName,
        $m_providerDescription,
        $m_contact,
        $m_providerType,
        $m_address);

  }

}
