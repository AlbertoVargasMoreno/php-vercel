<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    echo $email;
    // Takes raw data from the request
    $json = file_get_contents('php://input');
    // Converts it into a PHP object
    $data = json_decode($json);
}

$default_response = [
    "message" => "hi, there!"
];
$json_response = json_encode($default_response);
header('Content-type:application/json');
echo $json_response;
