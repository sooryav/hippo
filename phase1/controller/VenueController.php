<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../model/VenueModel.php');
require_once(__DIR__ . '/../html/view/VenueView.php');

class VenueController extends ControllerBase {

  public function __construct() {
    parent::__construct(get_class($this), '/venues');
  }

  <<Override>>
  public function execute(\Core\Context $context): void {
    // TODO: this function is not finished and will be cleaned up.
    $params = $context->m_request->m_params;
    if (!isset($params['page']))
    { 
      // TODO: create the totalVenuesCount function in the view.
      $view = <ui:venues:view totalVenuesCount={5}/>;
      $this->render($view->toString());
    }
    else
    {
      $venues = (new \Model\VenueModel())->getVenues();

      // TODO: Create a xhp class for this venue-list.
      $root = <ul />;
      foreach ($venues as $venue) {
      $root->appendChild(
        <li>
          {$venue->m_name . ': ' . $venue->m_zip}
        </li>);
      }

      $this->render($root->toString());
    }
  }
}

