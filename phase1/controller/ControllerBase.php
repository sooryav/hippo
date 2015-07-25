<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerInterface.php');
require_once(__DIR__ . '/../core/Context.php');

// ControllerBase implements IController interface and
// provides common functionalities.
abstract class ControllerBase implements ControllerInterface {

  protected function __construct(
    private string $m_name,
    private string $m_path,
    private \Core\Context $m_context,
    private Map<string, string> $m_inputs) {
  }

  public function getName(): string {
    return $this->m_name;
  }

  public function getPath(): string {
    return $this->m_path;
  }

  protected function getContext(): \Core\Context {
    //return null;
    return $this->m_context;
  }

  protected function getInputs() : Map<string, string> {
    return $this->m_inputs;
  }

  public function execute(): void {
    echo $this->render();
  }

  protected abstract function render(): :x:element;
}
