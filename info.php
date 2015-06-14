<?php 


//echo phpinfo(); 
//echo $_GET;
$location = "";
foreach($_GET as $key=>$val) {
  if ($key == "zip") { 
    $location = $val;
  }
}
$link = mysql_connect('localhost');
if (!$link) {
    die('Could not connect: ' . mysql_error());
}
//echo 'Connected successfully <br>';
$db_selected = mysql_select_db("test", $link);
if (!$db_selected) {
    die ('Can\'t use foo : ' . mysql_error());
}
$result = "";
if (!$location) {
  $result = mysql_query("SELECT * FROM Venue", $link);
} else {
  $query = sprintf("SELECT * FROM Venue WHERE zip='%s'", $location);
  $result =  mysql_query($query, $link);
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
  while ($row = mysql_fetch_array($result, MYSQL_ASSOC)) {
    $name = $row["name"];
    $website = $row["website"];
    $id = $row["id"];
    $table = $table . "<tr><td>". $id. "</td><td>" .$name. "</td><td><a href='" .$website. "'>".$website."</a></td><tr>";  
  }
  $table = $table . "</table>";
  echo $style.$table;
}
mysql_free_result($result);
mysql_close($link);


?>
