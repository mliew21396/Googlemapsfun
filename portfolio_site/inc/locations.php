<?php
//searches database and filters within the sql query rather than php
function get_locations_search($s) {
    
    require("database.php");

    try {
        $results = $db->prepare("
            SELECT *
            FROM us_bank
            WHERE title LIKE ?
            or zip Like ?");
        $results->bindValue(1,"%" . $s . "%");
        $results->bindValue(2,"%" . $s . "%");
        $results->execute();
    } catch (Exception $e) {
        echo "Data could not be retrieved from the datebase.";
        exit;
    }

    $matches = $results->fetchAll(PDO::FETCH_ASSOC);

    return $matches;
}
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
function calc_distance($point1, $point2)
{
    $radius      = 3958;      // Earth's radius (miles)
    $deg_per_rad = 57.29578;  // Number of degrees/radian (for conversion)

    $distance = ($radius * pi() * sqrt(
                ($point1['lat'] - $point2['lat'])
                * ($point1['lat'] - $point2['lat'])
                + cos($point1['lat'] / $deg_per_rad)  // Convert these to
                * cos($point2['lat'] / $deg_per_rad)  // radians for cos()
                * ($point1['long'] - $point2['long'])
                * ($point1['long'] - $point2['long'])
        ) / 180);

    return $distance;  // Returned using the units used for $radius.
}

?>