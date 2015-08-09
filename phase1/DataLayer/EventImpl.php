<?hh

namespace DataAccessLayer;

// TODO: Enable this once Seenu moves his code to use hhvm
//require_once(__DIR__ . '/HippoDataInterfaces.php');
require_once(__DIR__ . '/HippoDatabaseConnection.php');
require_once(__DIR__ . '/../entity/Event.php');

use Entity\Event;

interface IEventDataFactory {
    public function GetAllEventsByUserId(string $organizerUserId, int $maxCount = 1000);
    public function GetEventByEventId(string $eventId);
    public function DeleteEvent(string $eventId);
    public function AddEvent(Event $event);
};

class EventDataFactory implements IEventDataFactory {

  private $m_dbContext;
  private Vector<Event> $m_events = Vector{};
    
  public function __construct(IDataConnectionFactory $connectionFactory) {
   $this->m_dbContext = $connectionFactory->GetSharedConnection()->GetDataContext();      
  }

  private function GetEventsInternal(string $query): bool {
    
    $this->m_events.clear();
    
    $result = $this->m_dbContext->query($query);

    if (!$result) {
      echo "Error executing query: $query. Result: $result" . $this->m_dbContext->error;
      return false;
    }

    if ($result->num_rows == 0) {
      return false;
    }

    while($row = $result->fetch_array(MYSQL_ASSOC)) {
      $eventReminder = new EventReminder($row["SendReminder"],
                                         $row["ReminderMethod"],
                                         $row["ReminderTime"]
                                        );


      $this->m_events[] = new Event($row["EventId"], 
                               $row["ETag"], 
                               $row["Summary"], 
                               $row["Description"], 
                               $row["AddressId"],
                               $row["StartTime"],
                               $row["EndTime"],
                               $row["TimeZone"],
                               $row["MaxAttendees"],
                               $eventReminder,
                               $row["OrganizerUserId"],
                               $row["ColorId"]
                              );
    
    }

    $result->close();

    return true;
  }

  <<override>>
  public function GetAllEventsByUserId(string $organizerUserId, int $maxCount = 1000) {
    $this->m_events.clear();

    $query = "SELECT * FROM Hippo.Events where Events.OrganizerUserId = $organizerUserId";

    GetEventsInternal($query);
      
    return $this->m_events;
  }

  <<override>>
  public function GetEventByEventId(string $eventId) {
    if (!isset($eventId)) {
      return null;
    }

    $query = "SELECT * FROM Hippo.Events where Events.EventId = $eventId";

    $result = GetEventsInternal($query);
    return $result ? $this->m_events[0] : null;
  }
  
  <<override>>
  public function DeleteEvent(string $eventId) {
    if (!isset($eventId)) {
      return false;
    }

    $query = "DELETE FROM Hippo.Events where Events.EventId = $eventId";
    $result = $this->m_dbContext->query($query);

    return $result ? 'true' : 'false';
  }

  <<override>>
  public function AddEvent(Event $event) {
    if (!IsUserValid($event->m_organizerUserId))
    {
      echo "UserId: $event->m_organizerUserId does not exist in DB" . <br />;
      return false;
    }

    $query = "INSERT INTO `Hippo`.`Events` 
      (`EventId`, `ETag`, `Summary`, `Description`, 
       `LocationId`, `StartTime`, `EndTime`, `TimeZone`,
       `MaxAttendees`, `OrganizerUserId`, `ColorId`, 
       `SendReminder`, `ReminderMethod`, `ReminderTime` ) VALUES 
       ($event->m_eventId, 
        $event->m_etag, 
        $event->m_summary,
        $event->m_description, 
        $event->m_addressId, 
        $event->m_start,
        $event->m_end, 
        $event->m_timeZone, 
        $event->m_maxAttendees,
        $event->m_organizerUserId, 
        $event->m_colorId, 
        $event->m_eventReminder->m_sendReminder, 
        $event->m_eventReminder->m_reminderMethod,
        $event->m_eventReminder->m_minutes
      )";

    $result = $this->m_dbContext->query($query);

    return $result ? true : false;
  }

  // TODO: Remove this method and call into UserDataFactory to validate the user
  private function IsUserValid(int $userId): bool
  {
    $query = "SELECT * FROM Hippo.User where User.UserId = $userId";

    $result = $this->m_dbContext->query($query);

    if (!$result) {
      echo "Error executing query: $query. Result: $result" . $this->m_dbContext->error;
      return false;
    }

    if ($result->num_rows == 0) {
      return false;
    }
    
    return true;
  }

} 

