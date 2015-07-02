<?hh

namespace Core;

require_once(__DIR__ . '/LoggerInterface.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');

class Logger implements LoggerInterface {

  private \Monolog\Logger $logger;

  public function __construct(
    string $logName,
    Vector<\Monolog\Handler\HandlerInterface> $handlers,
    string $timeZone = 'America/Los_Angeles') {

    // The following is to subdue the strict warning from php.
    date_default_timezone_set($timeZone);

    $this->logger = new \Monolog\Logger($logName);

    foreach ($handlers as $handler) {
      $this->logger->pushHandler($handler);
    } 
  }

  public function info(
    string $message,
    LogContext $context = Map{}): void {

    $this->logger->info($message, $context->toArray());
  }

  public function warning(
    string $message,
    LogContext $context = Map{}): void {

    $this->logger->warning($message, $context->toArray());
  }

  public function error(
    string $message,
    LogContext $context = Map{}): void {

    $this->logger->error($message, $context->toArray());
  }

}

// Test script. This will be moved out from here soon. :)
$logger= new \Core\Logger(
  'mylog',
   Vector<Monolog\Handler\HandlerInterface> {});

$logger->error("Hello Log!");
$logger->info("Hello Log!");
$logger->warning("Hello Log!");
