<?php

namespace Html\View;

class ExampleView
{
    public function render(array $data)
    {
        echo "<HTML>\n"
            . "<HEAD><Title>ExampleView Page</TITLE></HEAD>\n"
            . "<BODY>\n"
            . "<TABLE>\n";
 
        foreach ($data as $key => $val)
        {
            echo "<TR>";
            echo "<TD>$key</TD>";
	    echo "<TD>$val</TD>";
            echo "</TR>\n";
        }
        
        echo "</TABLE>\n"
            . "</BODY>\n"
            . "</HTML>\n";
    }
}

?>
