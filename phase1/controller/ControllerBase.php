<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerInterface.php');

// ControllerBase implements IController interface and
// provides common functionalities.
abstract class ControllerBase implements ControllerInterface {

  protected function __construct(
    private string $name,
    private string $path) {
  }

  public function getName(): string {
    return $this->name;
  }

  public function getPath(): string {
    return $this->path;
  }

  public abstract function execute(Map<string, mixed> $inputs): void;

  protected function render(string $content): void {
    echo $content;
  }
}

