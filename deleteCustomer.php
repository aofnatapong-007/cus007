<?php
require "connect.php";

// รับค่ารหัสลูกค้าที่ส่งมากับ URL ผ่าน method GET
if (isset($_GET['CustomerID'])) {
    $CustomerID = $_GET['CustomerID'];

    try {
        // คำสั่ง SQL สำหรับลบข้อมูล
        $sql = "DELETE FROM customer WHERE CustomerID = :CustomerID";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':CustomerID', $CustomerID);

        if ($stmt->execute()) {
            // ลบสำเร็จ ให้เด้งกลับไปหน้า index.php
            echo "<script>
                    alert('ลบข้อมูลสำเร็จ');
                    window.location.href = 'index.php';
                  </script>";
        } else {
            echo "<script>alert('เกิดข้อผิดพลาดในการลบข้อมูล');</script>";
        }
    } catch (PDOException $e) {
        // กรณีที่มีตารางอื่นผูกข้อมูลไว้ (Foreign Key) อาจจะลบไม่ได้
        echo "Error: " . $e->getMessage();
        echo "<br><a href='index.php'>กลับหน้าแรก</a>";
    }
} else {
    echo "ไม่มีรหัสลูกค้าที่ต้องการลบ";
}
