<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../model/ExampleModel.php');
require_once(__DIR__ . '/../html/view/ExampleView.php');
require_once(__DIR__ . '/../html/view/SampleXHPView.php');
require_once(__DIR__ . '/../html/view/lib/composer/vendor/autoload.php');

class ExampleController extends ControllerBase
{
    public function __construct($path)
    {
        parent::__construct($path, get_class($this));
    }

    public function execute(array $inputs)
    {
        //$model = new \Model\ExampleModel();
        //$view = new \Html\View\ExampleView();
        //$view->render($model->getData($inputs));
        echo <sample:xhp:view />;
    }
}

