<?hh

namespace Core;

// Context class stores resources such as logger, which can
// be used throughout a request. Be very cautious adding memebers
// to this class as it can become unmanagable easily.
class Context {

  public function __construct(
    public LoggerInterface $m_logger) {
  }

}
