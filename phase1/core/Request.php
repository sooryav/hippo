<?hh

namespace Core;

// Request class contains request-specific information.
class Request {

  // $m_url: the request URI without the query string.
  //   If the original request URI was /foo/?bar=1,
  //   the $m_url passed in should be /foo.
  // $m_params: request parameters (such as from $_GET or $_POST).
  public function __construct(
    public string $m_url,
    public Map<string, mixed> $m_params) {
  }

}
