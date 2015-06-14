<?php

//printf("hello\n");

$location = "";
foreach($_GET as $key=>$val) {
  if ($key == "zip") { 
    $location = $val;
  }

  print ("Key is: $key<br>");
}


$mysqli = new mysqli("localhost", "root", "atulatul", "hippo");
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}
else
{
   echo "Connected successfully: " . $mysqli->host_info . "<br>";
}

$result = "";
if (!$location) {
  $result = $mysqli->query("SELECT * FROM Venue", $link);
} else {
  $query = sprintf("SELECT * FROM Venue WHERE zip='%s'", $location);
  $result =  $mysqli->query($query, $link);
}


$err   = mysql_error();
if ($err) {
  echo "error=$err  ";
} else {
  $style = "<style>
            table, th, td {
              border: 1px solid black;
              border-collapse: collapse;
            }
            th, td {
              padding: 5px;
              text-align: left;
            }
            </style>";
  $table = '<table border="">';
  $table = $table . "<tr><th>ID</th><th>VENUE</th><th>WEBSITE</th></tr>";
  while ($row = $result->fetch_assoc()) {
    $name = $row["name"];
    $website = $row["website"];
    $id = $row["id"];
    $table = $table . "<tr><td>". $id. "</td><td>" .$name. "</td><td><a href='" .$website. "'>".$website."</a></td><tr>";
  }
  $table = $table . "</table>";
  echo $style.$table;
}

mysqli_close($mysqli);

?>
