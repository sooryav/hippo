<?hh

namespace Controller;

require_once(__DIR__ . '/IController.php');

// ControllerBase implements IController interface and
// provides common functionalities.
abstract class ControllerBase implements IController {

  protected function __construct(private string $name) {
  }

  public function getName(): string {
    return $this->name;
  }

  public abstract function execute(Map<string, mixed> $inputs): void;

  protected function render(string $content): void {
    echo $content;
  }
}

