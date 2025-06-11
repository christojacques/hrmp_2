<?php
// Set your API key and the desired country code and year
$api_key = 'npn3c6mHbItioQely9BpeKyN2yoYhpSu';
$country_code = 'BD'; // Example: United States
$year = date('Y'); // Current year

// Make a request to the Calendarific API
$url = "https://calendarific.com/api/v2/holidays?api_key=$api_key&country=$country_code&year=$year";
$response = file_get_contents($url);

if ($response === false) {
    // Handle error if request fails
    die('Error retrieving data from the API.');
}

// Decode the JSON response
$data = json_decode($response, true);

// Check if the response was successful
if ($data['meta']['code'] == 200) {
    // Extract holidays from the response
    $holidays = $data['response']['holidays'];
    
    // Output the holidays
    foreach ($holidays as $holiday) {
        $date = new DateTime($holiday['date']['iso']);
        $date->setTimezone(new DateTimeZone('Asia/Dhaka'));
        echo $date->format('Y-m-d') . ' - ' . $holiday['name'] . "<br>";
    }
} else {
    // Handle error if response is not successful
    echo 'Error: ' . $data['meta']['error_detail'];
}
?>
