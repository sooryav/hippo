<?php

namespace Controller;

// Defines the interface for controllers.
interface IController
{
    // Returns the name of the controller.
    public function getName();

    // Returns the path for which the controller is invoked.
    public function getPath();

    // Executes the controller logic with given inputs.
    public function execute(array $inputs);
}

?>
