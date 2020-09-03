<?php

    require_once dirname(__FILE__) . "/includes/config.php";

    if (isset($_GET['delete'])) {

        $id = request_get($con, 'id');
    
        $query  = "DELETE FROM telefoonnummer WHERE lid_id='$id'";
        $result = $con->query($query);
        if(!$result) echo "DELETE failed";
    
        $query  = "DELETE FROM email WHERE lid_id='$id'";
        $result = $con->query($query);
        if(!$result) echo "DELETE failed";
    
        $query  = "DELETE FROM lid WHERE id=$id";
        $result = $con->query($query);
        if(!$result) echo "DELETE failed";
    
    }

    require_once dirname(__FILE__) . "/includes/queries.php";

    $sth = $con->query($query);

    $rows = $sth->fetch_all(MYSQLI_ASSOC);

?>

<!DOCTYPE html>
<html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <title>Document</title>
    </head>
    <body>
        <div class="container-fluid mt-5">

            <div class="d-flex justify-content-end">
                <a href="create.php">
                    <button type="button" class="btn btn-primary">Voeg nieuwe lid toe</button>
                </a>
            </div>
        
            <div class="card-body shadow mt-3">
            
                <table class="table table-hover">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Naam</th>
                            <th>Achternaam</th>
                            <th>Postcode</th>
                            <th>Huisnummer</th>
                            <th>Adres</th>
                            <th>Woonplaats</th>
                            <th>Telefoonnummer</th>
                            <th>Emailadres</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($rows as $row) {
                        ?>

                            <tr>
                                <td><?php echo $row["id"]; ?></td>
                                <td><?php echo $row["naam"]; ?></td>
                                <td><?php echo $row["achternaam"]; ?></td>
                                <td><?php echo $row["postcode"]; ?></td>
                                <td><?php echo $row["huisnummer"]; ?></td>
                                <td><?php echo $row["adres"]; ?></td>
                                <td><?php echo $row["woonplaats"]; ?></td>
                                <td><?php echo $row["telefoonnummer"]; ?></td>
                                <td><?php echo (strlen($row["email"]) > 30)  ? substr($row["email"], 0, 30) : $row["email"]; ?></td>
                                <td>
                                    <div class="d-flex">
                                        <div class="d-block mr-2">
                                            <a href="update.php" class="btn btn-info">Update</a>
                                        </div>
                                        <div class="d-block">
                                            <a href="delete.php?id=<?php echo $row["id"]; ?>" class="btn btn-danger">Verwijderen</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>

                        <?php
                            }
                        ?>
                    </tbody>
                </table>
            
            </div>

        </div>

    </body>
</html>