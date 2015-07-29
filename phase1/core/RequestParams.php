<?hh

namespace Core;

class RequestParams {

  public function __construct(
    private Map<string, mixed> $m_params) {
  }

  public function getString(string $name): ?string {
    return (string)$this->get<string>('is_string', $name);
  } 

  public function getInt(string $name): ?int {
    return (int)$this->get<int>('is_numeric', $name);
  } 

  public function getFloat(string $name): ?float {
    return (float)$this->get<float>('is_numeric', $name);
  } 

  private function get<T>(string $funcName, string $paramName): ?T {
    if (!$this->m_params->contains($paramName)) {
      return null;
    }

    $param = $this->m_params[$paramName];

    if (!call_user_func($funcName, $param)) {
      return null;
    }
    
    // Typecasting with generic T type is not supported.
    // So the type that is actually being returned is whatever
    // the type of $param is.
    return $param;
  }
}
