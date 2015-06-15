<?php

//printf("hello\n");

$location = "";
foreach($_GET as $key=>$val) {
  if ($key == "zip") { 
    $location = $val;
  }

  //print ("Key is: $key<br>");
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
  $result = $mysqli->query("SELECT * FROM vendor");
} else {
  $query = sprintf("SELECT * FROM vendor WHERE zip='%s'", $location);
  $result =  $mysqli->query($query);
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
  $table = $table . "<tr><th>FIRST NAME</th><th>LAST NAME</th><th>BUSINESS NAME</th><th>EMAIL</th><th>ADDRESS 1</th><th>CITY</th><th>STATE</th><th>ZIP</th><th>PHONE</th><th>CATEGORY</th><th>ID</th></tr>";

/*first_name VARCHAR(30) NOT NULL,
last_name VARCHAR(30) NOT NULL,
business_name VARCHAR(100) NOT NULL,
email VARCHAR(60) NULL,
address1 VARCHAR(60) NOT NULL,
address2 VARCHAR(60) NULL,
city VARCHAR(40) NOT NULL,
state VARCHAR(40) NOT NULL,
zip INT UNSIGNED NOT NULL,
phone VARCHAR(20) NOT NULL,
category_id SMALLINT NOT NULL,
vendor_id INT UNSIGNED NOT NULL PRIMARY KEY);
*/

  while ($row = $result->fetch_assoc()) {
    $firstName = $row["first_name"];
    $lastName = $row["last_name"];
    $businessName = $row["business_name"];
    $email = $row["email"];
    $address1 = $row["address1"];
    $city = $row["city"];
    $state = $row["state"];
    $zip = $row["zip"];
    //$table = $table . "<tr><td>". $id. "</td><td>" .$name. "</td><td><a href='" .$website. "'>".$website."</a></td><tr>";
    $table = $table . "<tr><td>" . $firstName . "</td><td>" . $lastName . "</td><td>" . $businessName . "</td><td>" . 
             $email . "</td><td>" . $address1 . "</td><td>" . $city . "</td><td>" . $state . "</td><td>" . $zip . "</td></tr>";

  }
  $table = $table . "</table>";
  echo $style.$table;
}

mysqli_close($mysqli);


