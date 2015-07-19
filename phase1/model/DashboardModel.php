<?hh

namespace Model;

require_once (__DIR__ . '/../entity/Provider.php');
require_once (__DIR__ . '/../entity/Address.php');

use Entity\Provider;
use Entity\Address;

class DashboardModel {

  // TODO: Somehow I am not able to get the syntax to work if I return \Entity\Provider
  // object type. I am able to return the return the actual object without explicitly
  // declaring the return type in function declaration

  public function getData(Map<string, mixed> $inputs) : \Entity\Provider {

    $address = new \Entity\Address("", "", "", "", "", "98034");
    $provider = new \Entity\Provider("atul", "gupta", "123-456-7890",  $address);

    //$jsonResponse =  json_encode($provider);
    //echo $jsonResponse;

    return $provider;
  }
}

