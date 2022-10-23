<?php


// Below is the api if you want to this file url to be an api to be used somewhere



include "db-connect.php"; // db connection

$json = file_get_contents('php://input'); // getting request body
$jo = json_decode($json); // decoding request body to json
$id =  $jo->id; // getting id from body

$select = "SELECT * FROM game WHERE id='$id'";
$run = mysqli_query($conn, $select);
$count = mysqli_num_rows($run);
if ($count > 0) {
    while ($row = mysqli_fetch_assoc($run)) {
        $emparray1[] = $row; // storing data in an array
        $obj = array("apiResponseMessage" => "Any message here", "apiResponseStatus" => false or true, "status" => 1 or 0, "response" => [$emparray1]); // array to send response back to request
        $data =  json_encode($emparray1, JSON_PRETTY_PRINT); // sending response back to request
    }
} else {
    $obj = array("apiResponseMessage" => "No Data", "apiResponseStatus" => false, "status" => 0, "response" => []); // response if no data found in database
    $nodata = json_encode($obj); // encoding array to json 
    echo $nodata;
}



// Below is the api if you want to post,update data to the url

//  API url
$url = 'https://example.com/api/login'; // url to fetch
$data = [
    'email' => 'admin@example.com',
    'pass' => 'example2022'
]; // data to send
// Initializes a new cURL session
$curl = curl_init($url);
// Set the CURLOPT_RETURNTRANSFER option to true
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
// Set the CURLOPT_POST option to true for POST request
curl_setopt($curl, CURLOPT_POST, true);
// Set the request data as JSON using json_encode function
curl_setopt($curl, CURLOPT_POSTFIELDS,  json_encode($data));
// Set custom headers for RapidAPI Auth and Content-Type header
curl_setopt($curl, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
]);
// Execute cURL request with all previous settings
$response = curl_exec($curl);
// Close cURL session
curl_close($curl);
// get the response into a json object
$json_response = json_decode($response);
// print the response
print_r($json_response);
// get the data from the response
print_r($json_response->apiResponseMessage);

// get the inner data if present in another array for example below response have an inner array
print_r($json_response->response[0]->id);
print_r($json_response->response[0]->user_email);