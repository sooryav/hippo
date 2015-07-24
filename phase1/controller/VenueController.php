<?hh

namespace Controller;

require_once(__DIR__ . '/ControllerBase.php');
require_once(__DIR__ . '/../model/VenueModel.php');
require_once(__DIR__ . '/../html/view/VenueView.php');
require_once(__DIR__ . '/../html/ui/VenueListElement.php');

class VenueController extends ControllerBase {

  public function __construct(\Core\Context $context, Map<string, string> $inputs) {
    parent::__construct(get_class($this), '/venues', $context, $inputs);
  }

  <<Override>>
  public function render(): :x:element {
    $params = $this->getContext()->m_request->m_params;
    $venueModel = new \Model\VenueModel();
    $view = null;

    // The first time this page is being loaded.
    if (!isset($params['page']))
    { 
      $view =
        <ui:venues:view
          totalVenuesCount={$venueModel->getTotalVenuesCount()}/>;
    }
    // The request is AJAX call to get venues information.
    else
    {
      $curPage = $params['page']; 

      $view =
        <ui:venue-list
          venues={$venueModel->getVenues()}
          id="venuesContainer"
          createContainer={$curPage == 0} />;
    }
    return $view;

  }
}

