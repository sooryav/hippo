<?hh

namespace Core;

type LogContext = Map<string, mixed>;

interface LoggerInterface
{
  public function info(
    string $message,
    LogContext $context = Map{}): void;

  public function warning(
    string $message,
    LogContext $context = Map{}): void;

  public function error(
    string $message,
    LogContext $context = Map{}): void;
}
