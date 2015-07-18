<?hh

namespace Controller;

require_once(__DIR__ . '/../core/Context.php');

// Defines the interface for controllers.
interface ControllerInterface {

  // Returns the name of the controller.
  public function getName(): string;

  // Returns the path for which the controller acts on.
  public function getPath(): string;

  // Executes the controller logic with a given context object.
  public function execute(\Core\Context $context): void;

}

