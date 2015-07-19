<?hh

namespace Entity;

class Address {

  public function __construct(
    public string $m_address1,
    public string $m_address2,
    public string $m_city,
    public string $m_state,
    public string $m_country,
    public string $m_zip) {
  }

}
