<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../model/VenueModel.php');
require_once(__DIR__ . '/../html/view/VenueView.php');
require_once(__DIR__ . '/../html/ui/VenueListElement.php');

class VenueController extends ControllerBase {

  public function __construct(\Core\Context $context) {
    parent::__construct(get_class($this), '/venues', $context);
  }

  <<Override>>
  public function render(): :x:element {
    $venueModel = new \Model\VenueModel();
    $curPage = $this->getRequestParams()->getInt('page');

    // The first time this page is being loaded.
    if (is_null($curPage))
    { 
      return
        <ui:venues:view
          totalVenuesCount={$venueModel->getTotalVenuesCount()}
        />;
    }
    // The request is AJAX call to get venues information.
    else
    {
      return
        <ui:venue-list
          venues={$venueModel->getVenues()}
          id="venuesContainer"
          createContainer={$curPage == 0}
        />;
    }
  }

}

