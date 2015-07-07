<?hh

namespace Core;

require_once(__DIR__ . '/LoggerInterface.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');

// Logger class implements LoggerInterface using the Monolog library.
class Logger implements LoggerInterface {

  private \Monolog\Logger $m_logger;

  public function __construct(
    string $logName,
    Vector<\Monolog\Handler\HandlerInterface> $handlers,
    string $timeZone = 'America/Los_Angeles') {

    // The following is to subdue the strict warning from php.
    date_default_timezone_set($timeZone);

    $this->m_logger = new \Monolog\Logger($logName);

    foreach ($handlers as $handler) {
      $this->m_logger->pushHandler($handler);
    } 
  }

  public function info(
    string $message,
    LogContext $context = Map{}): void {

    $this->m_logger->info($message, $context->toArray());
  }

  public function warning(
    string $message,
    LogContext $context = Map{}): void {

    $this->m_logger->warning($message, $context->toArray());
  }

  public function error(
    string $message,
    LogContext $context = Map{}): void {

    $this->m_logger->error($message, $context->toArray());
  }

}

