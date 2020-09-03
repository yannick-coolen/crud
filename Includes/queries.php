<?php

// GET queries
$query  = "SELECT l.id, l.naam, l.achternaam, l.postcode, l.huisnummer, 
p.adres, p.woonplaats, 
(select telefoonnummer from telefoonnummer where lid_id = l.id limit 0,1) as telefoonnummer,
(select email from email where lid_id = l.id limit 0,1) as email
FROM lid l 
-- Join postcode
JOIN postcode p ON l.postcode = p.postcode";

?>