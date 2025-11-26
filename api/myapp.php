<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

function isJson(string $string): bool {
   json_decode($string);
   return json_last_error() === JSON_ERROR_NONE;
}

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

$fileReaded = file_get_contents('notes.json');

$comments = isJson($fileReaded)
    ? json_decode($fileReaded, true)
    : [];
(!array_key_exists('comments', $comments)) && die("error decoding readed data");

/*
foreach ($comments['comments'] as $idx => $comment) {
    $note = $comment['comment'];
}

*/

$json_response = json_encode($comments);
header('Content-type:application/json');
echo $json_response;
