<?php
require "connect.php";

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

// เริ่มสร้างตาราง HTML
echo "<table border='1' style='border-collapse: collapse; width: 100%; text-align: left;'>";
echo "<tr style='background-color: #f2f2f2;'>
        <th>ID</th>
        <th>Name</th>
        <th>Email</th>
        <th>Country</th>
        <th>Debt</th>
      </tr>";

while ($row = $stmt->fetch()) {
    echo "<tr>";
    echo "<td>" . $row['CustomerID'] . "</td>";
    echo "<td>" . $row['Name'] . "</td>";
    echo "<td>" . $row['Email'] . "</td>";
    echo "<td>" . $row['CountryName'] . "</td>";
    echo "<td>" . number_format($row['OutstandingDebt'], 2) . "</td>"; // ใส่ format ตัวเลขให้ดูสวยขึ้น
    echo "</tr>";
}

echo "</table>";

$conn = null;
