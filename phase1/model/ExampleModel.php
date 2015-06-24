<?php

namespace Model;

class ExampleModel
{
    public function getData($inputs)
    {
        $data = [
            'a' => 1,
            'b' => 2,
            'c' => 3 ];
       
        return array_merge($inputs, $data);
    }
}

?>
