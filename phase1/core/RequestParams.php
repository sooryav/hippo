<?hh

namespace Core;

class RequestParams {

  public function __construct(
    private Map<string, mixed> $m_params) {
  }

  public function getString(string $name): ?string {
    $val = $this->get(fun('is_string'), $name);
    return $val == null ? null : (string)$val;
  } 

  public function getInt(string $name): ?int {
    $val = $this->get(fun('is_numeric'), $name);
    return $val == null ? null : (int)$val;
  } 

  public function getFloat(string $name): ?float {
    $val = $this->get(fun('is_numeric'), $name);
    return $val == null ? null : (float)$val;
  } 

  public function isEmpty(): bool {
    return $this->m_params->isEmpty();
  }

  // Typecasting with generic T type is not supported.
  // So the type that is actually being returned is whatever
  // the type of $param is. So the closest thing that can be specified
  // for the return type is mixed.
  private function get(
    (function(mixed): bool) $func,
    string $paramName): mixed {

    if (!$this->m_params->contains($paramName)) {
      return null;
    }
 
    $param = $this->m_params[$paramName];

    if (!call_user_func($func, $param)) {
      return null;
    }
    
    return $param;
  }

}
