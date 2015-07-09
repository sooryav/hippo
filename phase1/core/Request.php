<?hh

namespace Core;

// Request class contains request-specific information.
class Request {

  public function __construct(
    public string $m_url,
    public Map<string, mixed> $m_params) {
  }

}
