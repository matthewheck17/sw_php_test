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
        $stmt = $conn->prepare("SELECT comments,orderid FROM sweetwater_test"); //get all comments
        $stmt->execute();
        $result = $stmt->get_result();
        $miscArr = []; //init empy array for misc comments
        $candyArr = []; //init empty array for comments about candy
        $callArr = []; //init empty array for comments about calls
        $referralArr = []; //init empty array for comments about referrals
        $signArr = []; //init empty array for comments about signing

        
        while($row = $result->fetch_assoc()) {
            $used = false;
            if (stripos($row["comments"], 'candy')) { //find each comment that says candy in it
                array_push($candyArr, $row["comments"]); //push to candy array
                $used = true; 
            }

            //need to figure out way to get all relevant data and filter out non-relevant data
            if (stripos($row["comments"], 'don\'t call') || stripos($row["comments"], 'call me') || stripos($row["comments"], 'please call')) {
                array_push($callArr, $row["comments"]); //push to call array 
                $used = true; 
            }

            //need to figure out way to get all relevant data and filter out non-relevant data
            if (stripos($row["comments"], 'refer') || stripos($row["comments"], 'sales')) { //find each comment that says refer and sales in it
                array_push($referralArr, $row["comments"]); //push to referral array 
                $used = true; 
            }

            if (stripos($row["comments"], 'sign') ) { //find each comment that says sign in it
                array_push($signArr, $row["comments"]); //push to sign array 
                $used = true; 
            }

            if (stripos($row["comments"], 'Expected Ship Date:') ) { //find each comment that says sign in it
                $pos = strpos($row["comments"], 'Expected Ship Date:');
                $dateStr = substr($row["comments"], $pos + 20, 8) . " 00:00:00"; // extract date from each comment
                $phpDate = strtotime($dateStr);
                $formattedDate = date('Y-m-d H:i:s', $phpDate);
                $stmt2 = $conn->prepare("UPDATE sweetwater_test SET shipdate_expected = ? WHERE orderid = ?"); //get all comments
                $stmt2->bind_param('si', $formattedDate, $row['orderid']);
                $stmt2->execute();
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

        //referral comments table 
        echo '<table id="referral-table">';
        echo '<tr><th>Comments about referrals</th></tr>';
        foreach ($referralArr as &$value) {
            echo '<tr><td>' . $value .'</td></tr>'; //add each comment that said call to call table
        }
        echo '</table>';

        //signature comments table 
        echo '<table id="signature-table">';
        echo '<tr><th>Comments about signature</th></tr>';
        foreach ($signArr as &$value) {
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