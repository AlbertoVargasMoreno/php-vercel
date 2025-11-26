<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

function isJson(string $string): bool {
   json_decode($string);
   return json_last_error() === JSON_ERROR_NONE;
}

function appReadFile(string $filename = "notes.json"): array {
    $cwd = getcwd();
    var_dump($cwd); die();
    $fileReaded = file_get_contents($filename);
    $comments = isJson($fileReaded)
        ? json_decode($fileReaded, true)
        : [];
    (!array_key_exists('comments', $comments)) && die("error decoding readed data");
    return $comments;
}

function updateContent(array $comments, array $data) : string {
    $comments['comments'][] = $data;
    $json_response = json_encode($comments);
    return $json_response;
}

function writeFile(string $filename = "notes.json", string $content = "\n") : void {
    $myfile = fopen($filename, "w") or die("Unable to open file!");
    fwrite($myfile, $content);
    fclose($myfile);
}

$dataResponse = [];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $email = $_POST['email'];
    // echo $email;
    $json = file_get_contents('php://input');
    // var_dump($json);
    // echo PHP_EOL;
    $data = json_decode($json, true);

    $comments = appReadFile();
    $content = updateContent($comments, $data);
    writeFile(content: $content);

    $dataResponse = json_decode($content);
}

$default_response = [
    "message" => "hi, there!",
    "data" => $dataResponse
];

$json_response = json_encode($default_response);
header('Content-type:application/json');
echo $json_response;
