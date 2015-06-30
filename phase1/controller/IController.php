<?hh

namespace Controller;

// Defines the interface for controllers.
interface IController {

  // Returns the name of the controller.
  public function getName(): string;

  // Executes the controller logic with given inputs.
  public function execute(Map<string, mixed> $inputs): void;

}

