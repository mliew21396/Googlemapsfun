<?php
//--Model
//searches database and returns $matchess which contains all locations with distances
//away from search_term zip
function get_locations_search($s) {
    
    $true_zip = array();

    require("database.php");

    /*
    try {
        $results = $db->prepare("
            SELECT *
            FROM us_bank
            WHERE title LIKE ?
            or zip Like ?");
        $results->bindValue(1,"%" . $s . "%");
        $results->bindValue(2,"%" . $s . "%");
        $results->execute();    
    */        
    //Query database to gather entire database locations into $matches array
    try {
        $results = $db->query("
            SELECT *
            FROM us_bank");
    } catch (Exception $e) {
        echo "Data could not be retrieved from the datebase.";
        exit;
    };
    $matches = $results->fetchAll(PDO::FETCH_ASSOC);

    //inital query to take search_term zip and associate with latitudes and 
    //longitudes into $zipss
    if (is_numeric($s)){
        $num_length = strlen((string)$s);    
        if ($num_length == 5) {
            try {
                $results = $db->query("
                    SELECT *
                    FROM zips");
            } catch (Exception $e) {
                echo "Data could not be retrieved from the datebase.";
                exit;
            };
            $zipss = $results->fetchAll(PDO::FETCH_ASSOC);
            
            //the math to calculate the distance between the search_term and entire database
            $distances_from_results = calc_distance($zipss,$matches);

            //grab zip codes that match search term
            foreach ($distances_from_results as $key1 => $dist) {
                if ($dist['0'] == $s) {
                    $true_zip[] = $dist;
                 };
            };
            //first check if searched zip code is in database
            //second, query database for rest of properties for matched locations and
            //then add distance onto end of array for each match
            if (!empty($true_zip)) {
                for ($i=0; $i < count($true_zip) ; $i++) {
                    $true_zip2[] = ($true_zip[$i]['1']);
                };
            } else {
                return null;
            };
            //creates place_holder array for mysql query comparison with true_zip
            $place_holders = implode(',', array_fill(0, count($true_zip2), '?'));

                //query to grab all locations with true_zip
                try {
                        
                    $results = $db->prepare("
                        SELECT *
                        FROM us_bank
                        WHERE Title IN ($place_holders)");
                    $results->execute($true_zip2);
                    $matchess = $results->fetchAll(PDO::FETCH_ASSOC);                                                  
                    
                    /*
                    $results = $db->prepare("
                        SELECT *
                        FROM us_bank
                        WHERE Title LIKE ?");
                            for ($i=0; $i < count($true_zip) ; $i++) {                     
                                $results->bindValue(1,"%" . $true_zip[$i]['1'] . "%");
                                echo "$i";
                            };
                    $results->execute();                    
                    $matchess[] = $results->fetchAll(PDO::FETCH_ASSOC);
                    */

                    //adds the distance from true_zip array to the main matchess array
                    for ($i=0; $i < count($true_zip) ; $i++) {                                                    
                       $matchess[$i]['Distance']=$true_zip[$i]['2'];                                
                    };                               
                                            
                } catch (Exception $e) {
                    echo "Data could not be retrieved from the datebase.";
                    exit;
                };    
        } else {
            return null;
        };
    };
    return $matchess;
};
/*
//Currently obsolete and not used, but sends a query for all locations
function get_locations_all() {

    try {
        $db = new PDO("mysql:host=localhost;dbname=banks_db;port=3306","root","root");
        $db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
        $db->exec("SET NAMES 'utf8'");
    } catch (Exception $e) {
        echo "Could not connect to the database.";
        exit;
    }

    try {
        $results = $db->query("SELECT title FROM us_bank ORDER BY zip ASC");
    } catch (Exception $e) {
        echo "Data could not be retrieved from the database.";
        exit;
    }

    $locations = $results->fetchAll(PDO::FETCH_ASSOC);

    return $locations;
}
*/
//calculate distances between zip codes
//found here: http://stackoverflow.com/questions/407989/calculating-distance-between-zip-codes-in-php
function calc_distance($point1, $point2) {
    $radius      = 3958;      // Earth's radius (miles)
    $deg_per_rad = 57.29578;  // Number of degrees/radian (for conversion)
    $distance = "";
    //if (isset($point1,$point2)) {           
        /*
        echo "<br><br>";
        $d = $point1;//['Latitude'];
        print_r($d);
        echo "<br><br>";
        echo $d[0]['Zip'];
        echo "<br><br>";
        */
        //print_r($point1['Latitude']);       
        echo "<br><br>";
        foreach ($point1 as $key1 => $pointt1) {
            foreach ($point2 as $key2 => $pointt2) {
                //print_r($pointt2['Title']);
                //echo "<br>";
                $distance = ($radius * pi() * sqrt(
                            ($pointt1['Latitude'] - $pointt2['Latitude'])
                            * ($pointt1['Latitude'] - $pointt2['Latitude'])
                            + cos($pointt1['Latitude'] / $deg_per_rad)  // Convert these to
                            * cos($pointt2['Latitude'] / $deg_per_rad)  // radians for cos()
                            * ($pointt1['Longitude'] - $pointt2['Longitude'])
                            * ($pointt1['Longitude'] - $pointt2['Longitude'])
                    ) / 180);
                
                //echo $distance;//in radius units- miles
                //echo "<br>";
                $result = array($pointt1["Zip"],$pointt2['Title'],$distance);
                $results[] = $result;
                //print_r($results);
                //echo "<br><br>";

            };    
        };
        
    return $results;  // Returned using the units used for $radius.
};

