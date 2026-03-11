<?php
require "connect.php";

//$n = "1" . " or '1=1";
$cid = $_GET["CustomerID"];
$sql = "SELECT customer.CustomerID,
               customer.Name,
               customer.Email,
               country.CountryName,
               customer.OutstandingDebt
        FROM customer
        INNER JOIN country
        ON customer.CountryCode = country.CountryCode
        WHERE customer.CustomerID = :customerID";

$stmt = $conn->prepare($sql);

$stmt->bindParam(':customerID', $cid);

$stmt->execute();

$stmt->setFetchMode(PDO::FETCH_ASSOC);

while ($row = $stmt->fetch()) {
    echo $row['CustomerID'] . ' ' . $row['Name'] . ' ' . $row['Email'] . ' ' . $row['CountryName'] . ' ' . $row['OutstandingDebt'] . "<br/>";
}

$conn = null;
