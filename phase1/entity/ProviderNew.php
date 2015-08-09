<?hh

namespace Entity;

require_once(__DIR__ . '/Address.php');
require_once(__DIR__ . '/Contact.php');
require_once(__DIR__ . '/ProviderType.php');

// author: akhilj
// Creating a new version of Provider to avoid conflicts.
// This will be  a base class for different provider types.
abstract class ProviderNew {

  public function __construct(
    public string $m_providerId,
    public string $m_providerName,
    public string $m_providerDescription,
    public Vector<Contact> $m_contact,
    public ProviderType $m_providerType,
    public Vector<Address> $m_address) {
  }

  abstract public function getaddress() : Vector<Address> ;

}
