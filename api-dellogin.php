<?php
header('Content-Type: application/json');

require_once('./config.php');
date_default_timezone_set("Asia/Bangkok");

// ตรวจสอบว่า request method เป็น DELETE หรือไม่
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

  $query = "DELETE FROM user WHERE user_id=?";

    $stmt = $db->prepare($query);
    $stmt->execute([$_POST['id']]);

    // ตรวจสอบและเก็บผลลัพธ์
    if ($stmt->rowCount() > 0) {
        $object = new stdClass();
        $object->RespCode = 200;
        $object->RespMessage = 'Success';
    } else {
        $object = new stdClass();
        $object->RespCode = $_POST['id'];
        $object->RespMessage = 'Fail';
    }

    // ปิดการเชื่อมต่อ
    $db = null;

    // ส่งออกข้อมูลเป็น JSON
    header('Content-Type: application/json');
    echo json_encode($object);
    http_response_code(200);
} else {
    http_response_code(405);
}
?>