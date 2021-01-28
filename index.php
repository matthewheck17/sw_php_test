<?php
    include "dbconfig.inc.php";

    // Report all PHP errors
    error_reporting(E_ALL);

    $conn = openConnection(); //call openConnection function from dbconfig file to open connection with DB
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SW PHP TEST</title>
</head>
<body>
    <?php
        $stmt = $conn->prepare("SELECT comments FROM sweetwater_test"); //get all comments
        $stmt->execute();
        $result = $stmt->get_result();
        $candyArr = []; //init empty array for comments about candy
        
        while($row = $result->fetch_assoc()) {
            if (stripos($row["comments"], 'candy')) { //find each comment that says candy in it
                array_push($candyArr, $row["comments"]); //push to candy array 
            }
        }

        echo '<table id="candy-table">';
        echo '<tr><th>Comments about Candy</th></tr>';
        foreach ($candyArr as &$value) {
            echo '<tr><td>' . $value .'</td></tr>'; //add each comment that said candy to candy table
        }
        echo '</table>';
    ?>
</body>
</html>