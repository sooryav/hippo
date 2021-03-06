<?hh

require_once(__DIR__ . '/XPageView.php');
require_once(__DIR__ . '/../../lib/composer/vendor/autoload.php');
require_once(__DIR__ . '/../../google-api-php-client/autoload.php');
require_once(__DIR__ . '/../../entity/Provider.php');

use Entity\Provider;

class :ui:Dashboard extends :x:page:view {

  attribute Provider provider @required;
  attribute bool m_displayCalendar = false;

  private function getTable(): XHPRoot {
    $provider = $this->getAttribute('provider');
    $firstName = $provider->m_firstName;
    $lastName = $provider->m_lastName;

    $table =  
      <div class="table-responsive">
        <table class="table table-striped">
          <thead>
            <tr>
              <th>First Name</th>
              <th>Last Name</th>
           </tr>
          </thead>
          <tbody>
            <tr><td>{$firstName}</td><td>{$lastName}</td></tr>
          </tbody>
        </table>
        </div>;

    return $table;
  }

  <<Override>>
  public function getBody(): :x:frag {
    if (m_displayCalendar)
    {
      return <x:frag> {$this->DisplayCalendar()} </x:frag>;
    }
    
    return <x:frag> {$this->getTable()} </x:frag>;
  }

  <<Override>>
  protected function displayHeader() : bool {
    return false;
  }
  
  public function DisplayCalendar(): XHPRoot {
    $frame = 
      <iframe src="https://www.google.com/calendar/embed?src=atulgupta101%40gmail.com&ctz=America/Los_Angeles" 
        style="border: 0" width={800} height={600} />;

    return $frame;
  }

}

class :ui:TopNav extends :x:page:view {

  <<Override>>
  public function getBody(): :x:frag {
    //$nav = $this->getNavbar();
    $navRaw = $this->getNavbarRaw();
    //$button = $this->getButton();
    $frag = 
      <x:frag>
        <script src="../js/dashboard.js">
        </script>
      </x:frag>;
    //$frag->appendChild($nav);
    $frag->appendChild($navRaw);
    //$frag->appendChild($button);

    //$table = $this->getTable();
    //$frag->appendChild($table);

    return $frag;
  }

  <<Override>>
  protected function displayHeader() : bool {
    return false;
  }

  private function getButton(): XHPRoot {
    $button = 

      <form action="" method="post">
        <label>SEARCH...</label>
        <input type="text" name="name_entered" id="name" /><br></br>
        <input name="submitbutton" type="submit" value="Submit" />
      </form>;

    return $button;
  }

  // This will most likely move to some generic view later
  private function getNavbar(): XHPRoot {
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

  private function getNavbarRaw(): XHPRoot {
    $nav = 
      <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">Project name</a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
              <li><a id="calendar" href="#" onclick="DisplayCalendar(); return false;">Calendar</a></li>
              <li><a href="#">Dashboard</a></li>
              <li><a id="settings" href="#">Settings</a></li>
              <li><a id="profile" href="#" onclick="RedirectToProfile();return false;">Profile</a></li>
              <li><a href="#">Help</a></li>
            </ul>
            <!--form action="/dashboard" class="navbar-right" method="get">
              <input type="submit" name="GetProfile" value="Profile" />
            </form-->
            <form action="/dashboard" class="navbar-form navbar-right" method="post">
              <input type="text" name="SearchTab" class="form-control" placeholder="Search..." />
            </form>
          </div>
        </div>
        </nav>;

    return $nav;
  }
  
}

