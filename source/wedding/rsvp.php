<?php

  function escape($instring) {
    $outstring = stripslashes($instring);
    $outstring = str_replace("'", "&#39;", $outstring);
    $outstring = str_replace("<", "&lt;", $outstring);
    $outstring = str_replace(">", "&gt;", $outstring);
    return $outstring;
  }

  function unescape($instring) {
    $outstring = str_replace("&#39;", "'", $instring);
    $outstring = str_replace("&lt;", "<", $outstring);
    $outstring = str_replace("&gt;", ">", $outstring);
    return $outstring;
  }

  $state = "ENTRY";

  if ($_SERVER["REQUEST_METHOD"]=="POST") {
    $state = "POST";
    if (strpos($_SERVER["HTTP_REFERER"], $_SERVER["HTTP_HOST"])>7 || !strpos($_SERVER["HTTP_REFERER"], $_SERVER["HTTP_HOST"])) {
      $state = "ERROR";
      $error = "Bad referrer.";
    }
  }

  if ($state == "POST") {
    $attendance = $_REQUEST[attendance];
    $names = escape($_REQUEST[names]);
    $diet = escape($_REQUEST[diet]);
    $notes = escape($_REQUEST[notes]);
    if (trim($names) == "") {
      $state = "ERROR";
      $error = "Please enter name/s";
    } else {
      $message = "Attendance:\n" . $attendance;
      $message = $message . "\n\nNames:\n" . $names;
      $message = $message . "\n\nDiet:\n" . $diet;
      $message = $message . "\n\nNotes:\n" . $notes;
      if (mail("emma.sax@gmail.com", "Wedding RSVP", $message, "From: emma@punkchip.com", "-femma@punkchip.com")) {
        $state = "SUCCESS";
      } else {
        $state = "ERROR";
        $error = "Sorry, an ERROR occurred, please try again later.";
      }
    }
  }
?>

<!DOCTYPE html>
<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6"> <![endif]-->
<!--[if IE 7 ]> <html lang="en" class="no-js ie7"> <![endif]-->
<!--[if IE 8 ]> <html lang="en" class="no-js ie8"> <![endif]-->
<!--[if IE 9 ]> <html lang="en" class="no-js ie9"> <![endif]-->
<!--[if (gt IE 9)|!(IE)]> ><! <![endif]-->
<html class='no-js' lang='en'>
  <!-- <![endif] -->
  <head>
    <title>The Wedding: Emma &amp; Michael</title>
    <link href='../stylesheets/main.css' media='screen' rel='stylesheet' type='text/css' />
    <script src='../javascripts/modernizr.js'></script>
    <script src='https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js'></script>
  </head>
  <body>
    <header>
      <time>Emma and Michael's wedding: Saturday, 23 June 2012 at 3pm</time>
    </header>
    <div class='main-content'>
      <nav>
        <ul>
          <li>
            <a href='index.html'>
              Home
            </a>
          </li>
          <li>
            <a href='wedding.html'>
              The ceremony &amp; reception
            </a>
          </li>
          <li>
            <a href='gift-list.html'>
              Gift list
            </a>
          </li>
          <li>
            <a href='transport.html'>
              Transport &amp; travel
            </a>
          </li>
          <li>
            <a href='accommodation.html'>
              Where to stay
            </a>
          </li>
          <li class='last'>
            <a href='rsvp.php'>
              RSVP
            </a>
          </li>
        </ul>
      </nav>
      <div class='content'>

<?php
  if ($state == "ERROR") {
?>

  <p> <?=$error?></p>
  
<?php
  }
?>

<?php
  if ($state != "SUCCESS") {
?>
<h1>RSVP by 23 April 2012</h1>
<p>When you click "RSVP now" it will send us an email with all the information.</p>
<form action='rsvp.php' method='post'>
  <ul>
    <li>
      <ul class='invert'>
        <li>
          <input id='attendanceYes' name='attendance' type='radio' value='yes' />
          <label for='attendanceYes'>I / we will be attending</label>
        </li>
        <li>
          <input id='attendanceNo' name='attendance' type='radio' value='no' />
          <label for='attendanceNo'>I / we won't be attending</label>
        </li>
      </ul>
    </li>
    <li>
      <label for='names'>Names</label>
      <textarea id='names' name='names'></textarea>
    </li>
    <li>
      <label for='diet'>Dietary requirements</label>
      <textarea id='diet' name='diet'></textarea>
    </li>
    <li>
      <label for='notes'>Additional notes</label>
      <textarea id='notes' name='notes'></textarea>
    </li>
    <li>
      <button type='submit'>RSVP now</button>
    </li>
  </ul>
</form>

<?php
  } else {
?>

  <p> Thanks for submitting your RSVP</p>

<?php
  }
?>

      </div>
    </div>
    <footer>
      <p>
        2012
      </p>
    </footer>
  </body>
</html>
