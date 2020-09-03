<?php   // update-delete.php
require_once dirname(__FILE__) . "/includes/config.php";

// Valid
$good = true;
// Remove 'telefoonnummer' from textfield in update.php 
if (isset($_GET['lidid']) && 
    isset($_GET['tel']) 
)  {
    // Prepare message
    $log = [];
    // Get variables
    $lidid = $_GET['lidid'];
    $tel = $_GET['tel'];

    $log[] =  "Starting to delete telefoonnummer.";

    $query  = "DELETE FROM telefoonnummer WHERE lid_id='$lidid' AND telefoonnummer = '$tel'";
    $result = $con->query($query);
    if(!$result) {  //result not handeled of telefoonnummer 
        echo "DELETE failed, because telefoonnummer can't be deleted.";
    } else {    // result successfully handled of telefoonnummer
        $log[] =  "Telefoonnummer successfully deleted.";
    }
    // Go back to update.php
    header("location: update.php?id=$lidid");
}
// Remove 'email' from textfield in update.php 
if (isset($_GET['lidid']) && 
    isset($_GET['email']))  {
    // Prepare message
    $log = [];
    // Get variables
    $lidid = $_GET['lidid'];
    $tel = $_GET['email'];

    $log[] =  "Starting to delete email.";

    $query  = "DELETE FROM email WHERE lid_id='$lidid' AND email = '$tel '";
    $result = $con->query($query);
    // if ($tel < 1) {
    //     $good = false;
    //     echo "Er moet minimaal &eacute&eacuten telefoonnummer bestaan";
    // } else {
        
    // }
    if(!$result) {  //result not handeled of telefoonnummer 
        echo "DELETE failed, because telefoonnummer cannot be deleted.";
    } else {    // result successfully handled of telefoonnummer
        $log[] =  "Telefoonnummer successfully deleted.";
    }
    // Go back to update.php
    header("location: update.php?id=$lidid");
    }
?>