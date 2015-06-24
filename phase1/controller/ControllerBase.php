<?php

namespace Controller;

require_once(__DIR__ . '/IController.php');

abstract class ControllerBase implements IController
{
    // Stores the path for which the current contoller works.
    private $path;

    // Stores the name of the concrete class name.
    private $name;

    public function __construct($path, $name)
    {
        $this->path = $path;
        $this->name = $name;
    }

    public function getPath()
    {
        return $this->path;
    }

    public function getName()
    {
        return $this->name;
    }

    public abstract function execute(array $inputs);
}

?>
