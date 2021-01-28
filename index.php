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
        $miscArr = []; //init empy array for misc comments
        $candyArr = []; //init empty array for comments about candy
        $callArr = []; //init empty array for comments about candy
        
        while($row = $result->fetch_assoc()) {
            $used = false;
            if (stripos($row["comments"], 'candy')) { //find each comment that says candy in it
                array_push($candyArr, $row["comments"]); //push to candy array
                $used = true; 
            }

            //need to figure out way to get all relevant data and filter out non-relevant data
            if (stripos($row["comments"], 'don\'t call') || stripos($row["comments"], 'call me') || stripos($row["comments"], 'please call')) { //find each comment that says call in it
                array_push($callArr, $row["comments"]); //push to candy array 
                $used = true; 
            }

            if (!$used){
                array_push($miscArr, $row["comments"]); //push to candy array
            }
        }

        //candy table
        echo '<table id="candy-table">';
        echo '<tr><th>Comments about Candy</th></tr>';
        foreach ($candyArr as &$value) {
            echo '<tr><td>' . $value .'</td></tr>'; //add each comment that said candy to candy table
        }
        echo '</table>';


        //call and don't call table 
        echo '<table id="call-table">';
        echo '<tr><th>Comments about calls</th></tr>';
        foreach ($callArr as &$value) {
            echo '<tr><td>' . $value .'</td></tr>'; //add each comment that said call to call table
        }
        echo '</table>';


        //misc comment table 
        echo '<table id="misc-table">';
        echo '<tr><th>Miscellaneous Comments</th></tr>';
        foreach ($miscArr as &$value) {
            echo '<tr><td>' . $value .'</td></tr>'; //add each comment that said call to call table
        }
        echo '</table>';
    ?>
</body>
</html>