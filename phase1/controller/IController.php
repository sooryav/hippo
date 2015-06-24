<?php

namespace Controller;

interface IController
{
    public function getName();

    public function getPath();

    public function execute(array $inputs);
}

?>
