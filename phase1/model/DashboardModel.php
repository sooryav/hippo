<?hh

namespace Model;

require_once (__DIR__ . '/../entity/Provider.php');

use Entity\Provider;

class DashboardModel {

  public function getProfile(Map<string, mixed> $inputs): Provider {

    $address = new \Entity\Address("", "", "", "", "", "98034");
    $provider = new \Entity\Provider("atul", "gupta", "123-456-7890",  $address);

    //$jsonResponse =  json_encode($provider);
    //echo $jsonResponse;

    return $provider;
  }

}

