<?hh

namespace Core;

class RequestParams {

  public function __construct(
    private Map<string, mixed> $m_params) {
  }

  public function getString(string $name): ?string {
    return (string)$this->get(fun('is_string'), $name);
  } 

  public function getInt(string $name): ?int {
    return (int)$this->get(fun('is_numeric'), $name);
  } 

  public function getFloat(string $name): ?float {
    return (float)$this->get(fun('is_numeric'), $name);
  } 

  // TODO: not sure how to specify the type for $func and
  // return type of this function.
  private function get($func, string $paramName) {
    if (!$this->m_params->contains($paramName)) {
      return null;
    }

    $param = $this->m_params[$paramName];

    if (!call_user_func($func, $param)) {
      return null;
    }
    
    // Typecasting with generic T type is not supported.
    // So the type that is actually being returned is whatever
    // the type of $param is.
    return $param;
  }
}
