<?hh

namespace Entity;

// TODO: Not sure if we need to have an address for Contact.
// Address will be associated with Provider. I am leaving this here for now
require_once(__DIR__ . '/Address.php');

class Contact {

  public function __construct(
    public string $m_firstName,
    public string $m_lastName,
    public string $m_phone,
    public Address $m_address ) {
  }

}
