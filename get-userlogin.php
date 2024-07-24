<?php
require_once('./config.php');

// สร้างคำสั่ง SQL
if(isset($_GET["id"])){
    $query = "SELECT * FROM user WHERE user_id = ?";
    $stmt = $db->prepare($query);
$stmt->execute([$_GET["id"]]);
}else{
    $query = "SELECT * FROM user";  
        $stmt = $db->prepare($query);
$stmt->execute();
}
    


// ตรวจสอบและเก็บผลลัพธ์
$data = array();
if ($stmt->rowCount() > 0) {
    while($row = $stmt->fetch()) {
        $data[] = $row;
    }
} else {
    echo "0 results";
}

// ปิดการเชื่อมต่อ
$db = null;

// ส่งออกข้อมูลเป็น JSON
header('Content-Type: application/json');
echo json_encode($data);
?>
