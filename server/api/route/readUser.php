<?php
    header('Access-Control-Allow-Origin: *');
    header('Content-Type: application/json');
    
    include '../../config/database.php';
    include '../../models/Route.php';

    // Initiate DB and connect to it.
    $database = new Database();
    $db = $database->getConnection();

    // Initiate new car route.
    $route = new Route($db);

     // Get ID
    $route->licensePlate = $_GET['licensePlate'];
    
    // Route query
    $result = $route->readFullUser();
    
    // Get row count
    $num = $result->rowCount();

    // Check to see if there are routes
    if($num > 0) {
        // Init array
        $routes_arr = array();
        $routes_arr['data'] = array();

        while($row = $result->fetch(PDO::FETCH_ASSOC)) {
            extract($row);
            $route_item = array(
                'routeId' => $routeId,
                'licensePlate' => $licensePlate,
                'timeStart' =>date('yy-m-d M h:i:s', strtotime($timeStart)),
                'timeEnd' => date('yy-m-d M h:i:s', strtotime($timeEnd)),
                'distance' => $distance,
                'travelTime' => gmdate("H:i:s", $travelTime),
                'startAddress' => $startAddress,
                'stopAddress' => $stopAddress,
                'routeType' => $routeType,
                'liters' => $liters,
                'cost' => $cost,
                'firstLat' => $firstLat,
                'firstLon' => $firstLon,
                'lastLat' => $lastLat,
                'lastLon' => $lastLon,
                'odometerStop' => $odometerStop,
                'odometerStart' => $odometerStart
            );

            // Push to 'data'
            array_push($routes_arr['data'],$route_item);
        }
        // Turn it to json
        echo json_encode($routes_arr);
    } else {
        echo 'No data';
    }
?>