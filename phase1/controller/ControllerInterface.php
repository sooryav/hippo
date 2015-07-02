<?hh

namespace Controller;

// Defines the interface for controllers.
interface ControllerInterface {

  // Returns the name of the controller.
  public function getName(): string;

  // Returns the path for which the controller acts on.
  public function getPath(): string;

  // Executes the controller logic with given inputs.
  public function execute(Map<string, mixed> $inputs): void;

}

