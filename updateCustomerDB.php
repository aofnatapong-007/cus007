<?php
require "connect.php";

// รับค่าที่ส่งมาจากฟอร์มผ่าน method POST
$CustomerID = $_POST['CustomerID'];
$Name = $_POST['Name'];
$Birthdate = $_POST['Birthdate'];
$Email = $_POST['Email'];
$OutstandingDebt = $_POST['OutstandingDebt'];
$CountryCode = $_POST['CountryCode'];

try {
    // คำสั่ง SQL สำหรับอัปเดตข้อมูล
    $sql = "UPDATE customer SET 
            Name = :Name, 
            Birthdate = :Birthdate, 
            Email = :Email, 
            OutstandingDebt = :OutstandingDebt, 
            CountryCode = :CountryCode 
            WHERE CustomerID = :CustomerID";

    $stmt = $conn->prepare($sql);

    // ผูกค่าตัวแปรกับพารามิเตอร์
    $stmt->bindParam(':Name', $Name);
    $stmt->bindParam(':Birthdate', $Birthdate);
    $stmt->bindParam(':Email', $Email);
    $stmt->bindParam(':OutstandingDebt', $OutstandingDebt);
    $stmt->bindParam(':CountryCode', $CountryCode);
    $stmt->bindParam(':CustomerID', $CustomerID);

    // รันคำสั่ง
    if ($stmt->execute()) {
        // ถ้าสำเร็จให้เด้งกลับไปที่หน้า index.php
        echo "<script>
                alert('อัปเดตข้อมูลสำเร็จ');
                window.location.href = 'index.php';
              </script>";
    } else {
        echo "<script>alert('เกิดข้อผิดพลาดในการอัปเดตข้อมูล');</script>";
    }
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
