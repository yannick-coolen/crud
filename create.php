<?php   // Create.php

require_once dirname(__FILE__) . "/includes/config.php";
require_once dirname(__FILE__) . "/includes/queries.php";


$error_message = '';
$error_postcode = $error_telefoonnummer = $error_email = '';

$good = true;


// Insert postcode table
if (!empty($_POST['postcode'])      &&
    !empty($_POST['adres'])         &&
    !empty($_POST['woonplaats'])) {
        $postcode = get_post($con, 'postcode');
        // Check if all postcode is already inserted in the database
        $query  = "SELECT postcode FROM postcode where Postcode = '$postcode' ";
        $result = $con->query($query);
        $rows   = $result->num_rows;
        if ($rows>0) {
            $error_postcode = "Deze postcode is al ingevoerd in de database. ";
        }         
        else {
            $adres      = get_post($con, 'adres');
            if(!preg_match("/^[A-Za-z]+\s?[A-Za-z]+$/",($adres))) {
                $error_message = "Straatnaam is ongeldig";
                $good = false;
            }
            
            $woonplaats = get_post($con, 'woonplaats'); 
            if(!preg_match("/^[A-Za-z]+\s?[A-Za-z]+$/",($woonplaats))) {
                            $error_message = "Woonplaats is ongeldig";
                            $good = false;
                        }
            if ($good) {
            $adres    = get_post($con, 'adres');
            $woonplaats = get_post($con, 'woonplaats');
            $query      = "INSERT INTO postcode VALUES ('$postcode', '$adres', '$woonplaats')";
            $result     = $con->query($query);
            if (!$result) echo "INSERT failed "; 
            }
        }
    }
// Check if 'telefoonnummer' is valid (regex) and exist in the database (sql)
if (!empty($_POST['telefoon']))   {
    $telefoonnummer = get_post($con, 'telefoon');
    if(!preg_match("/^[0-9]+$/m",($telefoonnummer))) {      // Checks if 'telefoonnummer' is invalid
        $error_message = "Telefoonnummer is ongeldig. ";    // Sends back message when 'telefoonnummer' is invalid
        $good = false;
    }

    $query  = "SELECT * FROM telefoonnummer WHERE telefoonnummer = '$telefoonnummer'";
    $result = $con->query($query);
    $rows   = $result->num_rows;
    if($rows>0) {
        $good = false;
        $error_telefoonnummer = 'Deze telefoonnummer bestaat al in de database. ';
    }   
}
// Check if 'email' is valid (regex) and exist in the database (sql)
if (!empty($_POST['email']))   {
    $email = get_post($con, 'email');
    if(!preg_match("/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/",$email)) {   // Checks if 'email' is invalid
        $error_message = "Emailadres is ongeldig";                          // Sends back message when 'email' is invalid 
        $good = false;
    }

    $query  = "SELECT * FROM email WHERE email = '$email'";
    $result = $con->query($query);
    $rows   = $result->num_rows;
    if($rows>0) {
        // echo "Deze email bestaat al in de database ";
        $error_email = "Deze email bestaat al in de database";
    }
}
if (!empty($_POST['naam'])          &&
    !empty($_POST['achternaam'])    &&
    !empty($_POST['postcode'])      &&
    !empty($_POST['huisnummer'])    &&
    !empty($_POST['telefoon'])      &&
    !empty($_POST['email']))    {
        $naam     = get_post($con, 'naam');
        if(!preg_match("/^[A-Za-z]+$/",($naam))) {       // Checks if 'naam' is invalid
            $error_message = "Naam is ongeldig";        // Sends back message when 'naam' is invalid 
            $good = false;
        }
        $achternaam = get_post($con, 'achternaam');
        if(!preg_match("/^[A-Za-z]+\s?[A-Za-z]+$/",($achternaam))) {       // Checks if 'achternaam' is invalid
            $error_message = "Achternaam is ongeldig. ";     // Sends back message when 'achternaam' is invalid 
            $good = false;
        }
        $postcode   = get_post($con, 'postcode');
        if(!preg_match("/^[0-9]{4}+\s{0,1}+[A-z]{2}$/",($postcode))) {  // Checks if 'postcode' is invalid
            $error_message = "Postcode is ongeldig. ";                  // Sends back message when 'postcode' is invalid 
            $good = false;
        }
        $huisnummer  = get_post($con, 'huisnummer');
        if(!preg_match("/^[0-9]*[A-z]{0,1}+$/",($huisnummer))) {   // Checks if 'huisnummer' is invalid
            $error_message = "Huisnummer is ongeldig. ";            // Sends back message when 'huisnummer' is invalid
            $good = false;
        }
        // If good add to list
        if($good) {
            $query  = "INSERT INTO lid VALUES(NULL,'$naam', '$achternaam', '$postcode', '$huisnummer')";
            $result = $con->query($query);
            $lid_id = $con->insert_id;
            // Add telefoonnummer
            if (!empty($_POST['telefoon']))   {
                $telefoonnummer = get_post($con, 'telefoon');
                $query  = "INSERT INTO telefoonnummer VALUES ('$lid_id', '$telefoonnummer')";
                $result = $con->query($query);
                if(!$result) echo "INSERT telefoonnummer failed. ";
            }
            // Add email
            if (!empty($_POST['email']))   {
                $email  = get_post($con, 'email'); 
                $query  = "INSERT INTO email VALUES ('$lid_id', '$email')";
                $result = $con->query($query);
                if(!$result) echo "INSERT email failed. ";
            }
            // Sends back success message
            echo <<<_END
                <div class="bg-success text-white p-2">
                <p>Gegevens met success aan lijst toegevoegd.</p>
                </div>
            _END;
        } else { // Sends back error message
            echo <<<_END
            <div class="bg-warning text-white p-2">
            <p>$error_message $error_telefoonnummer $error_postcode</p>
            </div>
            _END; 
        }
    }
$con->close();
?>
<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <title>Document</title>
</head>
<body>
<div class="container p-3">
    <a href="ledenlijst.php">
        <button type="button" class="btn btn-success">Terug</button>
    </a>
</div>
<br><br>
<!-- Start form container -->
<div class="container p-3" style="background:grey; border-radius:0.25rem;">
    <!-- Start form lid -->
    <form action="create.php" method="post" style="padding: 1em;">
        <!-- Start 1st inputfields -->
        <div class="row">
            <!-- Naam -->
            <div class="col">
            <p>Naam:</p>  
            <input type="text" class="form-control" placeholder="Voer uw naam in" name="naam" required>
            </div>
            <!-- Achternaam -->
            <div class="col">
            <p>Achternaam: </p>  
            <input type="text" class="form-control" placeholder="Voer uw achternaam in" name="achternaam" required>
            </div>
        </div>
        <!-- End 1st inputfields -->
    <br>
        <!-- Start 2nd inputfields -->
        <div class="row">
            <!-- Postcode -->
            <div class="col">
                <p>Postcode:</p>  
                <input type="text" class="form-control" placeholder="Voer uw postcode in" name="postcode" required>
            </div>
            <!-- Huisnummer -->
            <div class="col">
                <p>Huisnummer: </p>  
                <input type="text" class="form-control" placeholder="Voer uw huisnummer in" name="huisnummer" required>
            </div>
        </div>
        <!-- End 2nd inputfields -->
        <br>
        <!-- Start 3rd inputfields-->
        <div class="row">
            <!-- Adres -->
            <div class="col">
                <p>Straat:</p>  
                <input type="text" class="form-control" placeholder="Voer uw straatnaam in" name="adres" required>
            </div>
            <!-- Woonplaats -->
            <div class="col">
                <p>Woonplaats: </p>  
                <input type="text" class="form-control" placeholder="Voer uw woonplaats in" name="woonplaats" required>
            </div>
        </div>
        <!-- End 3rd inputfields -->
        <br>
        <!-- Start 4th inputfields-->
        <div class="row">
            <!-- Adres -->
            <div class="col">
                <p>Telefoonnummer:</p>  
                <input type="text" class="form-control" placeholder="Voer uw telefoonnummer in" name="telefoon" required>
            </div>
            <!-- Woonplaats -->
            <div class="col">
                <p>Emailadres: </p>  
                <input type="text" class="form-control" placeholder="Voer uw emailadres in" name="email" required>
            </div>
        </div>
        <!-- End 4th inputfields -->
        <br>
        <input type="submit" class="btn btn-primary btn-block" value="Voeg toe aan lijst"> 
    </form>
<!-- End form container-->
</html>