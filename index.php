<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Weather Application</title>
</head>

<body>
    <h1>Simple Weather application in PHP</h1>
</body>
<form method="post">
    <label for="city">Please enter the name of the city</label>
    <input type="text" id="city" name="city">
    <button> Get Weather </button>
</form>

</html>
<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $city = $_POST["city"];

    $headers = [
        "Authorization: Client-ID XYJOJcS8JPXZ9sFQu1xss1QLN9gc-vcFcdZxYrN2ljk"
    ];

    $photourl = "https://api.unsplash.com/photos/random?query=$city&count=1";

    $url = "api.openweathermap.org/data/2.5/weather?q=$city&APPID=fb7f4425cec8b8fb7202f8375a2c3d03";

    $ch = curl_init();

    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,

    ]);

    $response = curl_exec($ch);

    curl_setopt_array($ch, [
        CURLOPT_URL => $photourl,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => $headers
    ]);

    $response2 = curl_exec($ch);
    $photo = json_decode($response2, true);
    $randomPhoto = $photo[0]["urls"]["regular"];

    curl_close($ch);

    $response = json_decode($response, true);
    $kelvin = $response["main"]["temp"];
    $celcius = $kelvin - 273.15;
    // var_dump($kelvin);
    echo "<p> Weather in " . $city . " is " . round($celcius) . "°C celcius<p>";

    echo "<img src=\"$randomPhoto\" alt=\"random image of $city\" width=\"300\" height=\"400\">";
}
?>