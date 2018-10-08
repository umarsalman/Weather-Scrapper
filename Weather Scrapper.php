<?php
  $weather = "";
  $city = "";
  $error = "";

  if (array_key_exists('city', $_GET)) {
    $city = $_GET['city'];
    $_GET['city']= str_replace(' ', '', $_GET['city']);

    $file_headers = @get_headers("https://www.weather-forecast.com/locations/" . $_GET['city'] . "/forecasts/latest");

    if (!$file_headers || $file_headers[0] == 'HTTP/1.1 404 Not Found') {
      $error = "Sorry for the inconvinience, this city could not be found";
    } else {
      $forecast = file_get_contents("https://www.weather-forecast.com/locations/" . $_GET['city'] . "/forecasts/latest");
      $split = explode('3 days)</span><p class="b-forecast__table-description-content"><span class="phrase">', $forecast);

      if (sizeof($split) > 1) {
        $required = explode('<td class="b-forecast__table-description-cell--js" colspan="9"><span class="b-forecast__table-description-title"><h2>', $split[1]);

        if (sizeof($required) > 1) {
          $weather = $required[0];
        } else {
          $error = "Sorry for the inconvinience, this city could not be found";
        }
      } else {
        $error = "Sorry for the inconvinience, this city could not be found";
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
      .container {
          text-align:center;
          width:450px;
      }

      body {
          width:100%;
          margin:0 auto;
          padding:0px;
          font-family:sans-serif;
          background-color:#81DAF5;

          background: url(https://wallpaperscraft.com/image/ocean_atlantic_horizon_sunset_113029_1920x1080.jpg) no-repeat center center fixed;
          -webkit-background-size: cover;
          -moz-background-size: cover;
          -o-background-size: cover;
          background-size: cover;
      }
      h1 {
          margin-top:100px;
          font-weight:bold;
          color:#0B2241;
      }
      p {
          font-weight:bold;
          font-size:140%;
          color:#0B2241;
      }
  </style>
  </head>
    <body>
      <div class="container">
          <h1>What's the weather!</h1>
          <p>Enter the city name</p>

          <form>
              <div class="form-group">
                  <input value="<?php
                  if (array_key_exists('city', $_GET)) {
                    echo $city;
                  }
                  ?>" name="city" type="text" class="form-control" id="city" placeholder="eg Delhi,Lucknow,London">
              </div>
              <button type="submit" class="btn btn-dark">Check</button>
          </form>
          <div>
              <?php
              if ($weather) {
                echo '<br><div class="alert alert-success" role="alert">'.$weather.'</div>';
              } elseif($error) {
                echo '<br><div class="alert alert-danger" role="alert">'.$error.'</div>';
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
