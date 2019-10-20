<?php
$weather = '';
$city = '';
$error = '';
$forecastSite = 'https://www.weather-forecast.com/locations/{city}/forecasts/latest';
if (array_key_exists('city', $_GET)) {
    $city = str_replace(' ', '-', $_GET['city']);
    $forecastUrl = str_replace('{city}', $city, $forecastSite);

    $file_headers = @get_headers($forecastUrl);
    if (!is_array($file_headers) || $file_headers[0] != 'HTTP/1.1 200 OK') {
        $error = true;
    } else {
        $forecast = file_get_contents($forecastUrl);
        $split = explode('</h2>(1&ndash;3 days)</span><p class="b-forecast__table-description-content"><span class="phrase">', $forecast);

        if (count($split) > 1) {
            $required = explode('</span>', $split[1]);
            if (!empty($required)) {
                $weather = $required[0];
            } else {
                $error = true;
            }
        } else {
            $error = true;
        }
    }
}
?>


<!doctype html>
<html lang="en">

<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css" integrity="sha384-Gn5384xqQ1aoWXA+058RXPxPg6fy4IWvTNh0E263XmFcJlSAwiGgFAW/dAiS6JXm" crossorigin="anonymous">

    <title>Weather Scrapper</title>
    <style type="text/css">
        body {

            width: 100%;
            margin: 0 auto;
            padding: 0px;
            font-family: sans-serif;
            background-color: #81DAF5;

            background: url(https://wallpaperscraft.com/image/ocean_atlantic_horizon_sunset_113029_1920x1080.jpg) no-repeat center center fixed;
            -webkit-background-size: cover;
            -moz-background-size: cover;
            -o-background-size: cover;
            background-size: cover;
        }

        h1 {
            margin-top: 100px;
            font-weight: bold;
            color: #0B2241;
        }

        p {
            font-weight: bold;
            font-size: 140%;
            color: #0B2241;
        }

        .container {
            text-align: center;
            width: 450px;
        }
    </style>
    <!-- adding the ajax Code for auto complete -->
    <link href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/themes/base/jquery-ui.css" rel="stylesheet" type="text/css" />
    <script src="http://ajax.googleapis.com/ajax/libs/jquery/1.5/jquery.min.js"></script>
    <script>
        // put a focus on the field
        $(document).ready(function() {
            $('#city').focus();
        });
        $(document).ready(function() {
            $('#city').autocomplete({
                //using locationautocomplete.php to get the suggestions
                source: "locationautocomplete.php"

            });
        });
    </script>
</head>

<body>
    <div class="container">
        <h1>What's the weather!</h1>
        <p>Enter the city name</p>

        <form>
            <div class="form-group">
                <input list="cities" id="city-choice" name="city" class="form-control" placeholder="eg Delhi,Lucknow,London" value="<?php
                                                                                                                                    if (array_key_exists('city', $_GET)) {
                                                                                                                                        echo $city;
                                                                                                                                    }
                                                                                                                                    ?>" />
                <datalist id="cities">
                    <option value="Barcelona">
                    <option value="Delhi">
                    <option value="London">
                    <option value="Lucknow">
                    <option value="Beijin">
                    <option value="Cape Town">
                    <option value="Lusaka">
                    <option value="Lagos">
                </datalist>
            </div>
            <button type="submit" class="btn btn-dark">Check</button>


        </form>
        <div><?php

                if ($weather) {
                    echo '<br><div class="alert alert-success" role="alert">' . $weather . '</div>';
                }

                if ($error) {
                    echo '<br><div class="alert alert-danger" role="alert">Sorry for the inconvenience, this city could not be found</div>';
                }
                ?>
        </div>
    </div>
    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
</body>

</html>