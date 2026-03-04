<?php
require "connect.php";

$sql_c = "SELECT * FROM customer,country 
          WHERE customer.CountryCode = country.CountryCode 
          AND CustomerID = :CID";
$stmt_customer = $conn->prepare($sql_c);
$stmt_customer->bindParam(':CID', $_GET['CustomerID']);
$stmt_customer->execute();
$result_customer = $stmt_customer->fetch(PDO::FETCH_ASSOC);

$sql_country = "SELECT * FROM country";
$stmt_c = $conn->prepare($sql_country);
$stmt_c->execute();
$cc = $stmt_c->fetchAll();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>updatecustomer.php</title>
</head>

<body>
    <h2>แก้ไขข้อมูลลูกค้าเข้าฐานข้อมูล</h2>

    <form action="updateCustomerDB.php" method="POST">
        <label>รหัสลูกค้า: </label>
        <input type="text" placeholder="กรุณากรอกรหัสลูกค้า" name="CustomerID" value="<?= $result_customer['CustomerID'] ?>" readonly>
        <br> <br>

        <label>ชื่อ นามสกุล: </label>
        <input type="text" name="Name" class="form-control" value="<?= $result_customer['Name'] ?>">
        <br> <br>

        <label>วันเกิด: </label>
        <input type="date" placeholder="กรุณากรอกวันเกิดลูกค้า" name="Birthdate" value="<?= $result_customer['Birthdate'] ?>">
        <br> <br>

        <label>Email: </label>
        <input type="email" placeholder="กรุณากรอกอีเมลล์ลูกค้า" name="Email" value="<?= $result_customer['Email'] ?>">
        <br> <br>

        <label>ยอดหนี้: </label>
        <input type="number" placeholder="กรุณากรอกยอดหนี้ลูกค้า" name="OutstandingDebt" value="<?= $result_customer['OutstandingDebt'] ?>">
        <br> <br>

        <label>กรุณาเลือกประเทศ: </label>
        <select name="CountryCode" id="CountryCode">
            <?php
            $selected = $result_customer['CountryName'];
            foreach ($cc as $c) {
                if ($selected == $c['CountryName']) {
                    echo '<option selected value="' . $c['CountryCode'] . '">' . $c['CountryName'] . '</option>';
                } else {
                    echo '<option value="' . $c['CountryCode'] . '">' . $c['CountryName'] . '</option>';
                }
            }
            ?>
        </select>
        <br> <br>
        <input type="submit" value="บันทึกข้อมูล">
        <a href="index.php"><button type="button">ยกเลิก</button></a>
    </form>

</body>

</html>