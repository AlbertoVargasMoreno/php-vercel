<?php
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->safeLoad();

function isJson(string $string): bool {
   json_decode($string);
   return json_last_error() === JSON_ERROR_NONE;
}

function fetchJsonDataWithCurl(string $url) {
    try {
        $curl = curl_init($url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        $jsonString = curl_exec($curl);
        
        if (curl_errno($curl)) {
            throw new Exception('cURL error: ' . curl_error($curl));
        }
        
        $httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
        curl_close($curl);
        if ($httpCode !== 200) {
            throw new Exception('Network response was not ok. HTTP Code: ' . $httpCode);
        }
        
        $jsonData = isJson($jsonString)
            ? json_decode($jsonString, true)
            : [];
        
        // print_r($jsonData);
        return $jsonData;
    } catch (Exception $error) {
        echo 'Error fetching JSON data: ' . $error->getMessage();
        return null;
    }
}

function appReadFile(string $filename = "notes.json") {
    $client = new \VercelBlobPhp\Client();
    $result = $client->head($filename);
    $url = $result->url ?? '';
    $comments = fetchJsonDataWithCurl($url);
    (!array_key_exists('comments', $comments)) && die("error decoding readed data");
    return $comments;
}

function updateContent(array $comments, array $data) : string {
    $comments['comments'][] = $data;
    $json_response = json_encode($comments);
    return $json_response;
}

function writeFile(string $filename = "notes.json", string $content = "\n") : void {
    // $myfile = fopen($filename, "w") or die("Unable to open file!");

    $client = new \VercelBlobPhp\Client();
    $result = $client->put(
        path: $filename,
        content: $content,
    );
    $dataResponse = $result;
    // vercel doesn't grant writing permissions, and VERCEL-BLOB isn't available for PHP
    // fwrite($myfile, $content);
    // fclose($myfile);
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
    // $content = updateContent($comments, $data);
    // writeFile(content: $content);

    // $dataResponse = json_decode($content);
    $dataResponse = $comments;
}

$default_response = [
    "message" => "hi, there!",
    "data" => $dataResponse
];

$json_response = json_encode($default_response);
header('Content-type:application/json');
echo $json_response;
