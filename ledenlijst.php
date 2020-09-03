<?php   // ledenlijst.php

    require_once dirname(__FILE__) . "/includes/config.php";
    require_once dirname(__FILE__) . "/includes/queries.php";

    $sth = $con->query($query);

    $rows = $sth->fetch_all(MYSQLI_ASSOC);

?>
<!-- HTML -->
<!DOCTYPE html>
<html lang="nl">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <title>Document</title>
    </head>
    <body>
        <!-- Start of table container -->
        <div class="container-fluid mt-5">
            <!-- Start of go to create.php -->
            <div class="d-flex justify-content-end">
                <a href="create.php">
                    <button type="button" class="btn btn-primary">Voeg nieuwe lid toe</button>
                </a>
            </div>
            <!-- End of go to create.php -->
            <!-- Read table -->
            <div>
                <table class="table table-hover card-body shadow mt-3">
                    <thead class="thead-dark">
                        <tr>
                            <th>ID</th>
                            <th>Naam</th>
                            <th>Achternaam</th>
                            <th>Postcode</th>
                            <th>Huisnr</th>
                            <th>Straat</th>
                            <th>Woonplaats</th>
                            <th>Telefoonnr</th>
                            <th>Emailadres</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            foreach ($rows as $row) {
                        ?>
                            <!-- Show data in row -->
                            <tr>
                                <!-- Show ID from database -->
                                <td><?php echo $row["id"]; ?></td> 
                                <!-- Show Naam from database -->
                                <td><?php echo $row["naam"]; ?></td>
                                <!-- Show Achternaam from database -->
                                <td><?php echo $row["achternaam"]; ?></td>
                                <!-- Show Postcode from database -->  
                                <td><?php echo $row["postcode"]; ?></td>
                                <!-- Show huisnummer from database -->    
                                <td><?php echo $row["huisnummer"]; ?></td>
                                <!-- Show adres from database-->  
                                <td><?php echo $row["adres"]; ?></td>
                                <!-- Show woonplaats from database-->
                                <td><?php echo $row["woonplaats"]; ?></td>
                                <!-- Show telefoonnummer from database-->
                                <td><?php echo $row["telefoonnummer"]; ?></td>
                                <!-- Show email from database -->
                                <td><?php echo (strlen($row["email"]) > 30)  ? substr($row["email"], 0, 30) : $row["email"]; ?></td>
                               <!-- Action buttons -->
                                <td>
                                    <div class="d-flex">
                                        <!-- Go to page update.php -->
                                        <div class="d-block mr-1">
                                            <a href="update.php?id=<?php echo $row["id"]; ?>" class="btn btn-info">Update</a>
                                        </div>
                                        <!-- Delete row -->
                                        <div class="d-block">
                                            <form action="delete.php" method="post">
                                                <input type="hidden" name="id" value="<?php echo $row["id"];?>">
                                                <button type="submit" class="btn btn-danger">Verwijderen</button>
                                            </form>
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
            <!-- End of read table -->
        </div>
        <!-- End of table container -->
    </body>
</html>