<?php

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');

class ErrorController extends ControllerBase
{
    public function __construct($path)
    {
        parent::__construct($path, get_class($this));
    }

    public function execute(array $inputs)
    {
        echo "<HTML>\n"
            . "<HEAD><Title>Error Page</TITLE></HEAD>\n"
            . "<BODY>\n"
	    . "<p>" . $inputs['message'] . "</p>"
            . "</BODY>\n"
            . "</HTML>\n";
    }
}

?>
