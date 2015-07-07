<?hh

namespace Core;

require_once(__DIR__ . '/Logger.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');

use Monolog\Handler\BufferHandler;
use Monolog\Handler\StreamHandler;

class LoggerFactory {

  public function create(string $name): LoggerInterface {
    // TODO: Replace stream handler with a handler that
    // writes to the database.
    $bufferHandler = new BufferHandler(
      new StreamHandler(
        'php://stderr',
        \Monolog\Logger::DEBUG));

    return new Logger($name, Vector{ $bufferHandler });
  }

}

// Test script. This will be moved out from here soon. :)
$logger = (new LoggerFactory())->create('mylog');

$logger->error("Hello Log!");
$logger->info("Hello Log!");
$logger->warning("Hello Log!");
