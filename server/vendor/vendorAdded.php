<html>
<head>
<title>Add Vendor</title>
</head>
<body>

<?php


if (isset($_POST['submit']))
{
    $missingData = array();
    $firstName = "";
    $lastName = "";
    $zip = 0;

    if (empty( $_POST['first_name']))
    {
        $missingData[] = 'First Name';
        echo "Mandatory field First Name is missing<br>";
    }
    else
    {
        $firstName = trim($_POST['first_name']);
    }


    if (empty( $_POST['last_name']))
    {
        $missingData[] = 'Last Name';
        echo "Mandatory field Last Name is missing<br>";
    }
    else
    {
        $lastName = trim($_POST['last_name']);
    }

    if (empty( $_POST['zip']))
    {
        $missingData[] = 'Zip Code';
        echo "Mandatory field Zip Code is missing<br>";
    }
    else
    {
        $zip = trim($_POST['zip']);
    }


    if (empty($missingData))
    {
        require_once('../connection.php');

        $query = "INSERT INTO vendor (first_name, last_name, zip) VALUES (?, ?, ?)";

        $stmt = $mysqli->prepare($query);
        $stmt->bind_param('ssi', $firstName, $lastName, $zip);
        $stmt->execute();

        printf("%d Row inserted.\n", $stmt->affected_rows);

        $stmt->close();
        $mysqli->close();
    }
}
  

?>

