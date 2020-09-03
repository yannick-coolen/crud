<?php   // delete.php
require_once dirname(__FILE__) . "/includes/config.php";

if (isset($_POST['id']))  {

    // Prepare message
    $log = [];

    $id = get_post($con, 'id');

    $log[] =  "Starting to delete telefoonnummer.";

    $query  = "DELETE FROM telefoonnummer WHERE lid_id='$id'";
    $result = $con->query($query);
    if(!$result) {  //result not handeled of telefoonnummer 
        echo "DELETE failed, because telefoonnummer can't be deleted.";
    } else {    // result successfully handled of telefoonnummer
        $log[] =  "Telefoonnummer successfully deleted.";
    }

    $query  = "DELETE FROM email WHERE lid_id='$id'";
    $result = $con->query($query);
    if(!$result) {  //result not handeled of email 
        echo "DELETE failed, because email can't be deleted.";
    } else {    // result successfully handled of email
        $log[] =  "email successfully deleted.";
    }

    $query  = "DELETE FROM lid WHERE id=$id";
    $result = $con->query($query);
    if(!$result) {  //result not handeled of lid
        echo "DELETE failed, because lid can't be deleted.";
    } else {    // result successfully handled of lid
        $log[] =  "Lid successfully deleted.";
    }

}
// Go back to ledenlijst.php
header("location: ledenlijst.php");
?>