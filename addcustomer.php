<!DOCTYPE html>
<html>

<head>
    <title>User Registration</title>
</head>

<body>
    <h1>Add Customer</h1>

    <?php
    require 'connect.php';

    try {
        $sql_country = "SELECT CountryCode, CountryName FROM country";
        $stmt_country = $conn->prepare($sql_country);
        $stmt_country->execute();
        $countries = $stmt_country->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        echo "Error fetching countries: " . $e->getMessage();
    }
    ?>

    <form action="addcustomer.php" method="POST">
        <input type="text" placeholder="Enter Customer ID" name="customerID" required>
        <br><br>
        <input type="text" placeholder="Name" name="Name" required>
        <br><br>
        <input type="date" placeholder="Birthdate" name="birthdate" required>
        <br><br>
        <input type="email" placeholder="Email" name="email" required>
        <br><br>

        <select name="countryCode" required>
            <option value="">-- Select Country Code --</option>
            <?php foreach ($countries as $country) { ?>
                <option value="<?php echo $country['CountryCode']; ?>">
                    <?php echo $country['CountryName'] . " (" . $country['CountryCode'] . ")"; ?>
                </option>
            <?php } ?>
        </select>
        <br><br>

        <input type="number" placeholder="OutStanding debt" name="outstandingDebt" step="0.01">
        <br><br>
        <input type="submit" value="Add Customer">
        <a href="index.php"><button type="button">กลับสู่หน้าหลัก</button></a>
    </form>

    <br>
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && !empty($_POST['customerID'])):
        try {
            $sql = "INSERT INTO customer (CustomerID, Name, Birthdate, Email, CountryCode, OutstandingDebt) 
                    VALUES (:customerID, :Name, :birthdate, :email, :countryCode, :outstandingDebt)";

            $stmt = $conn->prepare($sql);

            $stmt->bindParam(':customerID', $_POST['customerID']);
            $stmt->bindParam(':Name', $_POST['Name']);
            $stmt->bindParam(':birthdate', $_POST['birthdate']);
            $stmt->bindParam(':email', $_POST['email']);
            $stmt->bindParam(':countryCode', $_POST['countryCode']);
            $stmt->bindParam(':outstandingDebt', $_POST['outstandingDebt']);

            if ($stmt->execute()):
                echo '<p style="color:green;">Successfully added new customer!</p>';
                // แจ้งเตือนและเด้งกลับหน้าแรกอัตโนมัติ
                echo "<script>
                        alert('เพิ่มข้อมูลลูกค้าสำเร็จ');
                        window.location.href = 'index.php';
                      </script>";
            else:
                echo '<p style="color:red;">Failed to add customer.</p>';
            endif;
        } catch (PDOException $e) {
            echo '<p style="color:red;">Error: ' . $e->getMessage() . '</p>';
        }

        $conn = null;
    endif;
    ?>
</body>

</html>