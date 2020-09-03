<?php
require_once dirname(__FILE__) . '/includes/config.php';
require_once dirname(__FILE__) . '/includes/queries.php'; 

$error_message = '';
$error_postcode = $error_telefoonnummer = $error_email = '';

$good = true;

//stap 1: voeg postcode toe
if (isset($_POST["action"])) {
        $postcode = get_post($con, 'postcode');
        $lid_id = get_post($con, 'id');

        // Is the postcode valid?

        // Is the number valid?
        
        //check if all postcode is already inserted in the database
        // $query  = "SELECT postcode FROM postcode where Postcode = '$postcode' ";
        // $result = $con->query($query);
        // $rows   = $result->num_rows;
        // if ($rows>0) {
        //     echo "Deze postcode is al ingevoerd in de database";
        // } else {
        //     $adres      = get_post($con, 'adres');
        //     $woonplaats = get_post($con, 'woonplaats');
        //     $query      = "INSERT INTO postcode VALUES ('$postcode', '$adres', '$woonplaats')";

        //     $result     = $con->query($query);
        //     if (!$result) echo "insert failed"; 
        // }
    if (!empty($_POST['naam'])          &&
        !empty($_POST['achternaam'])    &&
        !empty($_POST['huisnummer']))    {
        $naam           = get_post($con, 'naam');
        if(!preg_match("/^[A-Za-z]+$/m",($naam))) {     // Checks if 'naam' is invalid
            $error_message = "Naam is ongeldig";        // Sends back message when 'naam' is invalid 
            $good = false;
        }
        $achternaam     = get_post($con, 'achternaam');
        if(!preg_match("/^[A-Za-z]+$/m",($naam))) {     // Checks if 'naam' is invalid
            $error_message = "Naam is ongeldig";        // Sends back message when 'naam' is invalid 
            $good = false;
        }
        $huisnummer     = get_post($con, 'huisnummer');
        if(!preg_match("/^[0-9]*[A-z]{0,1}+$/m",($huisnummer))) {   // Checks if 'huisnummer' is invalid
            $error_message = "Huisnummer is ongeldig. ";            // Sends back message when 'huisnummer' is invalid
            $good = false;
        }
        // Modify lid
        if($good) {
        $query = "UPDATE `lid` SET `naam` = '$naam', `achternaam` = '$achternaam', `huisnummer` = '$huisnummer' WHERE `lid`.`id` = '$lid_id'"; 

        $result         = $con->query($query);
        $lid_id         = $con->insert_id;   

        // Sends back success message
        echo <<<_END
        <div class="bg-info text-white p-2">
        <p>De gegevens zijn aangepast.</p>
        </div>
        _END;
        } else {
            // Sends back error message
            echo <<<_END
            <div class="bg-warning text-white p-2">
            <p>$error_message $error_postcode $error_telefoonnummer</p>
            </div>
            _END; 
        }
    }   
}

// Add extra number
if (!empty($_POST['telefoonnummer'])) {
    $lid_id     = get_post($con, 'id');
    $telefoon   = get_post($con, 'telefoonnummer');
    if(!preg_match("/^[0-9]+$/m",($telefoon))) {            // Checks if 'telefoonnummer' is invalid
        $error_message = "Telefoonnummer is ongeldig. ";    // Sends back message when 'telefoonnummer' is invalid
        $good = false;
    }
    if ($good) {
    $query = "INSERT INTO `telefoonnummer` (`lid_id`, `telefoonnummer`) VALUES ('$lid_id', '$telefoon')";

    $result = $con->query($query);
    // Sends back success message
    echo <<<_END
    <div class="bg-success text-white p-2">
    <p>Gegevens met success aan lijst toegevoegd.</p>
    </div>
    _END;
    } else {
        // Sends back error message
        echo <<<_END
        <div class="bg-warning text-white p-2">
        <p>$error_message $error_postcode $error_telefoonnummer</p>
        </div>
        _END; 
    }
}

// Add extra email 
if (!empty($_POST['email'])) {
    $lid_id     = get_post($con, 'id');
    $email   = get_post($con, 'email');
    if(!preg_match("/^[a-z0-9._%+-]+@[a-z0-9.-]+\.[a-z]{2,}$/",$email)) {   // Checks if 'email' is invalid
        $error_message = "Emailadres is ongeldig";                          // Sends back message when 'email' is invalid 
        $good = false;
    }
    if ($good) {
    $query = "INSERT INTO `email` (`lid_id`, `email`) VALUES ('$lid_id', '$email')";

    $result = $con->query($query);
    // Sends back success message
    echo <<<_END
    <div class="bg-success text-white p-2">
    <p>Gegevens met success aan lijst toegevoegd.</p>
    </div>
    _END;
    } else {
        // Sends back error message
        echo <<<_END
        <div class="bg-warning text-white p-2">
        <p>$error_message $error_postcode $error_telefoonnummer</p>
        </div>
        _END; 
    }
}

// Get all data from database and make it a string
$lid_id = htmlspecialchars($_GET["id"]);
if($lid_id == "")
    $lid_id = $_POST["id"];
$query = "SELECT l.id, l.naam, l.achternaam, l.postcode, l.huisnummer, p.adres, p.woonplaats FROM lid l
-- Join postcode
JOIN postcode p ON l.postcode = p.postcode
WHERE l.id = $lid_id"; 

$result = $con->query($query);

$rows = $result->fetch_all(MYSQLI_ASSOC);

foreach ($rows as $row) {
?>
<!-- HTML -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
<div class="container p-3">
    <a href="ledenlijst.php">
        <button type="button" class="btn btn-success">Terug</button>
    </a>
</div>
<br><br>
    <div class="container">
        <form action="update.php" method="POST" style="padding: 1em;">
        <input type="hidden" name="action" value="update">
        <input type="hidden" name="id" value="<?php echo $row['id'];?>">
        <!-- Start 1st inputfields -->
            <div class="row">
                <!-- Naam -->
                <div class="col">
                <p>Naam:</p>
                <input type="text" class="form-control" name="naam" value="<?php echo $row['naam'];?>">
                </div>
                <!-- Achternaam -->
                <div class="col">
                <p>Achternaam:</p>  
                <input type="text" class="form-control" placeholder="Voer uw achternaam in" name="achternaam" value="<?php echo $row['achternaam'];?>">
                </div>
            </div>
            <!-- End 1st inputfields -->
        <br>
            <!-- Start 2nd inputfields -->
            <div class="row">
                <!-- Naam -->
                <div class="col">
                <p>Wijzig adres:</p> 
                <select class="form-control" name="" id="">
                    <option value=""><?php echo $row['postcode'] . ', ' . $row['adres'] . ', ' . $row['woonplaats'];;?></option>
                <!-- <input type="text" class="form-control"  value="<?php echo $row['postcode'] . ', ' . $row['adres'] . ', ' . $row['woonplaats'];?>"> -->
                </select> 
                </div>
                <!-- huisnummer -->
                <div class="col">
                    <div class="row">
                    <!-- Telefoonnummer -->
                        <div class="col">
                        <p>Huidige adres:</p>  
                        <input type="text" class="form-control" placeholder="Voer uw achternaam in" name="huisnummer" value="<?php echo $row['postcode'] . ', ' . $row['adres'] . ', '. $row['woonplaats'] ;?>">
                        </div>
                        <div class="col-sm-4">
                        <p>Huisnummer:</p>  
                        <input type="text" class="form-control" placeholder="Voer uw achternaam in" name="huisnummer" value="<?php echo $row['huisnummer'];?>">
                        </div>
                    </div>
                </div>
            </div>
            <!-- End 2nd inputfields -->
            <br>
            <button type="submit" class="btn btn-info">Wijzig</button> 
        </form>
        <form action="update.php" method="POST" style="padding: 1em;">
        <input type="hidden" name="id" value="<?php echo $lid_id;?>">
        <?php
        //Nieuwe query
        //Selecteer alle telefoonnummers van het lid $lid_id
        $query2 = "SELECT telefoonnummer FROM telefoonnummer WHERE lid_id ='$lid_id'"; 
        $result2 = $con->query($query2);
        $rows2 = $result2->fetch_all(MYSQLI_ASSOC);
        ?>
            <!-- End 3rd inputfields -->
            <br>
            <!-- Start 4th inputfields-->
            <div class="row">
                <!-- Telefoonnummer -->
                <div class="col">
                    <p>Telefoonnummer:</p>  
                    <input type="text" class="form-control" placeholder="Voer uw adres in" name="telefoonnummer"> <br>
                    <button type="submit" class="btn btn-info" name="add_phone">Voeg toe</button>
                </div>
                <!-- Textfield -->
                <div class="col">
                    <div class="sub-container pl-3 pt-2">
                        <?php  foreach ($rows2 as $row) {?>
                            <?php echo "<ul><li>".$row["telefoonnummer"] . "<span class='ml-3'><a href='' class='close' aria-label='Close'>X</a></span>"."</li></ul>"; 
                            ?>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- End 4th inputfields -->
        </form>
        <!-- Add Phonenumber -->
        <form action="update.php" method="POST" style="padding: 1em;">
        <input type="hidden" name="id" value="<?php echo $lid_id;?>">
        <?php
        //Nieuwe query
        //Selecteer alle telefoonnummers van het lid $lid_id
        $query3 = "SELECT email FROM email WHERE lid_id ='$lid_id'"; 
        $result3 = $con->query($query3);
        $rows3 = $result3->fetch_all(MYSQLI_ASSOC);
        ?>
            <!-- Start 5th inputfields-->
            <div class="row">
                <!-- Adres -->
                <div class="col">
                    <p>Emailadres:</p>  
                    <input type="text" class="form-control" placeholder="Voer uw emailadres in" name="email"> <br>
                    <button type="submit" class="btn btn-info" name="add_email">Voeg toe</button>
                </div>
                <!-- Textfield -->
                <div class="col">
                    <div class="sub-container pl-3 pt-2">
                        <?php foreach ($rows3 as $row) {?>
                            <?php echo "<ul><li>". $row["email"] . "<span class='ml-3'><a href='' class='close' aria-label='Close'>X</a></span>"."</li></ul>";?>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <!-- End 5th inputfields -->
            <br>
        </form>
    </div>
</body>
</html>
<?php
    }
?>