<?hh

require_once(__DIR__ . '/XPageView.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');
require_once(__DIR__ . '/../../entity/Provider.php');
require_once(__DIR__ . '/../../entity/Address.php');

use Entity\Provider;
use Entity\Address;

class :Dashboard:xhp:view extends :x:page:view {
  attribute Entity\Provider provider @required;

  // This will most likely move to some generic view later
  private function getNavbar() : XHPRoot {

    $nav = <nav class="navbar navbar-inverse navbar-fixed-top" />;
      $div1 = <div class="container-fluid" />;
      $nav->appendChild($div1);
        $div2 = <div class="navbar-header" />;
        $div1->appendChild($div2);
          $button = <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" 
            aria-expanded="false" aria-control="narbar" />;
          $div2->appendChild($button);
            $span1 = <span class="sr-only">Toggle navigation</span>;
            $button->appendChild($span1);
            $span2 = <span class="icon-bar" />;
            $button->appendChild($span2);
            $span3 = <span class="icon-bar" />;
            $button->appendChild($span3);
            $span4 = <span class="icon-bar" />;
            $button->appendChild($span4);
            
         $a = <a class="navbar-brand" href="#">Hippo</a>;
         $div2->appendChild($a);
       
       $div3 = <div id="navbar" class="navbar-collapse collapse" />;
       $div1->appendChild($div3);
         $ul = <ul class="nav navbar-nav navbar-right" />;
         $div3->appendChild($ul);
           $li1 = <li><a href="#">Dashboard</a></li>;  
           $ul->appendChild($li1);
           $li2 = <li><a href="#">Settings</a></li>;  
           $ul->appendChild($li2);
           $li3 = <li><a href="#">Profile</a></li>;  
           $ul->appendChild($li3);
           $li4 = <li><a href="#">Help</a></li>;  
           $ul->appendChild($li4);
         $form1 = <form class="navbar-form navbar-right" />;
         $div3->appendChild($form1);
           $input = <input type="text" class="form-control" placeholder="Search..." />;
           $form1->appendChild($input);
      
    return $nav;
  }

  <<Override>>
  public function getBody(): :x:frag {

    $nav = $this->getNavbar();

    $frag = <x:frag />;
    $frag->appendChild($nav);

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

