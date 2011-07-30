<?php

$qry = "INSERT INTO results (";
$fields = "";
$vals = "";

if (!(isset($_POST["submit"])))
{
    echo "You bought it";
    return;
}

if (!($conn = mysql_connect("localhost:3306", "marcom_andrews", "Zp}O}TanTdFh")))
{
    die("Couldn't connect to database server");
}

while(list($key, $value) = each($_POST))
{
    if ($key == "submit")
    {
        continue;
    }

    if ($key == "recommend" && !(empty($value)))
    {
        if ($value = mysql_real_escape_string($value))
        {
  	    $value = substr($value, 0, 130);
            $value = "'" . $value . "'";
	}
        else
        {
	    echo "Something ain't right";
      	    return;
	}
    }

    if ($value == "on")
    {
        $value = 1;
    }

    if (!(empty($value)))
    {
        $fields = $fields . $key . ", ";
        $vals = $vals . $value . ", ";
    }
}

//$fields = substr($fields, 0, -2);
//$vals = substr($vals, 0, -2);

if (!isset($email))
{
    $email = "support@ftwbox.com";    
}

$fields = $fields . "email, time_entered";
$vals = $vals . "'" . $email . "', NOW()";

$qry = $qry . $fields . ") VALUES (" . $vals . "); ";

if (!mysql_select_db("marcom_survey",$conn))
{
    die("Couldn't select database");
}

if (!(mysql_query($qry, $conn)))
{
    echo $qry;
    echo "This is embarrassing";
    die("Couldn't perform query");   
}

header('Location: http://ftwbox.com');
  
?>