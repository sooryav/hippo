<?hh

namespace Tests\Mock;

require_once(__DIR__ . '/../../core/logger/LoggerInterface.php');

use Core\LoggerInterface;
use Core\LogContext;

// Logger class implements LoggerInterface using the Monolog library.
class MockLogger implements LoggerInterface {

  public function info(
    string $message,
    LogContext $context = Map{}): void {}

  public function warning(
    string $message,
    LogContext $context = Map{}): void {}

  public function error(
    string $message,
    LogContext $context = Map{}): void {}

}

