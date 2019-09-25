<?php

if (strlen($_GET['q']) < 3) return json_encode([]);

// Get cURL resource
$curl = curl_init();
// Set some options - we are passing in a useragent too here
curl_setopt_array($curl, [
    CURLOPT_RETURNTRANSFER => 1,
    CURLOPT_URL => "http://dicionario-aberto.net/search-json?like={$_GET['q']}",
]);

// Send the request & save response to $resp
$words = json_decode(curl_exec($curl), true);

// Close request to clear up some resources
curl_close($curl);

$searchString = $_GET['q'];
$input = preg_quote($searchString, '/'); // don't forget to quote input string!

$result = preg_grep('/^' . $input . '/i', $words['list']);
echo json_encode(array_values($result));
