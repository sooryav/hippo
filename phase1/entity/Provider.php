<?hh

namespace Entity;

require_once(__DIR__ . '/Address.php');

class Provider {

  public function __construct(
    public string $m_firstName,
    public string $m_lastName,
    public string $m_phone,
    public Address $m_address ) {
  }

}
