<?hh

namespace Model;

class ExampleModel {

  public function getData(Map<string, mixed> $inputs): Map<string, mixed> {
    $inputs['a'] = 1;
    $inputs['b'] = 2;
    $inputs['c'] = 3;

    return $inputs;
  }

}

