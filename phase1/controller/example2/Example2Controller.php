<?php

namespace Controller;

require_once(__DIR__ . '/../ControllerBase.php');
require_once(__DIR__ . '/../../model/ExampleModel.php');
require_once(__DIR__ . '/../../html/view/ExampleView.php');

class Example2Controller extends ControllerBase
{
    public function __construct($path)
    {
        parent::__construct($path, get_class($this));
    }

    public function execute(array $inputs)
    {
        $model = new \Model\ExampleModel();
        $view = new \Html\View\ExampleView();
        $view->render($model->getData($inputs));
    }
}

?>
