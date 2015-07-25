<?hh

namespace Model;

require_once (__DIR__ . '/../core/Context.php');

//Database Information
class DatabaseHandler {

const DB_HOST = "localhost"; //Host address (most likely localhost)
const DB_NAME = "test"; //Name of Database
const DB_USER = "root"; //Name of database user
const DB_PASS = "pwd"; //Password for database user
const DB_TABLE_PREFIX = "test_";
private
  $m_mysqli = null,
  $errors = array(),
  $successes = array();

// Create a new mysqli object with database connection parameters
public function getDBConnection() {
  if ($this->m_mysqli === null) {
    $this->m_mysqli = new \mysqli(
      self::DB_HOST,
      self::DB_USER,
      self::DB_PASS,
      self::DB_NAME
    );
  }
  if(mysqli_connect_errno()) {
    // TODO: Log error using MonoLog
    die("Connection Failed: " . mysqli_connect_errno());
  }
  return $this->m_mysqli;
}

}