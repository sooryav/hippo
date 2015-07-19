<?hh

require_once(__DIR__ . '/XPageView.php');
require_once(__DIR__ . '/lib/composer/vendor/autoload.php');
require_once(__DIR__ . '/../../entity/Provider.php');
require_once(__DIR__ . '/../../entity/Address.php');

use Entity\Provider;
use Entity\Address;

class :Dashboard:xhp:view extends :x:page:view {
  attribute Entity\Provider provider @required;

  <<Override>>
  public function getBody(): :x:frag {
    
    $frag = <x:frag />;
    $table = <bootstrap:table hover-rows={true}/>;
    $table->addClass("table-responsive");
    $table->addClass("table-striped");
    $thead = <thead />;
    $row = <tr />;

    $row->appendChild(<th>First Name</th>);
    $row->appendChild(<th>Last Name</th>);
    $thead->appendChild($row);

    $tbody = <tbody />;

    $provider = $this->getAttribute('provider');

    $firstName = $provider->m_firstName;
    $lastName = $provider->m_lastName;

    $trow = <tr><td>{$firstName}</td><td>{$lastName}</td></tr>;
    $tbody->appendChild($trow);

    $table->appendChild($thead);
    $table->appendChild($tbody);
    
    $frag->appendChild($table);

    return $frag;
  }
}

