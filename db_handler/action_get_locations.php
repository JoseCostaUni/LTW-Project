<?php
function get_coordinates_locationiq($address){

    $response = @file_get_contents($url);

    if ($response === FALSE) {
        echo "Error: Could not get a response from the LocationIQ API.\n";
        return null;
    }

    $data = json_decode($response, true);

    if ($data === null && json_last_error() !== JSON_ERROR_NONE) {
        echo "Error: Failed to decode the JSON response.\n";
        return null;
    }

    if (count($data) > 0) {
        $location = $data[0];
        return array('lat' => $location['lat'], 'lng' => $location['lon']);
    } else {
        echo "Error: No results found.\n";
        return null;
    }
}

function haversineDistance($latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371) {
    $latFrom = deg2rad($latitudeFrom);
    $lonFrom = deg2rad($longitudeFrom);
    $latTo = deg2rad($latitudeTo);
    $lonTo = deg2rad($longitudeTo);

    $latDelta = $latTo - $latFrom;
    $lonDelta = $lonTo - $lonFrom;

    $a = sin($latDelta / 2) * sin($latDelta / 2) + cos($latFrom) * cos($latTo) * sin($lonDelta / 2) * sin($lonDelta / 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

    return $earthRadius * $c;
}

require_once '../db_handler/DB.php';
require_once '../db_handler/Item.php';
require_once '../db_handler/Users.php';

session_start();

if ($_SESSION['csrf'] !== $_POST['csrf_token']) {
    exit();
}

$userId = $_SESSION['userId'];

$itemIds = json_decode($_POST['itemIds'], true);

$db = new Database("../database/database.db");

$location = $db->getUserById($userId)->getAddress();

$coordinates_sender = get_coordinates_locationiq($location);

if ($coordinates_sender !== null) {
    $lat_receiver = $coordinates_sender['lat'];
    $lon_receiver = $coordinates_sender['lng'];
}

$distances = array();

foreach($itemIds as $itemId){
    $item = $db->getItemById($itemId);
    $sellerId = $item->getUserId();
    $user = $db->getUserById($sellerId);
    $address = $user->getAddress();
    $coordinates = get_coordinates_locationiq($address);
    if ($coordinates !== null) {
        $lat = $coordinates['lat'];
        $lon = $coordinates['lng'];
    }

    $distance = haversineDistance($lat, $lon, $lat_receiver, $lon_receiver);

    $distances[] = $distance;
}

    echo json_encode($distances);

?>