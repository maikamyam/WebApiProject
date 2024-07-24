<?php
header('Content-Type: application/json');

require_once('./config.php');
date_default_timezone_set("Asia/Bangkok");

function generateRandomString($length = 10)
{
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if(isset($_POST['name'])){
        $txt_username = $_POST['name'];
    }
    else return;
    if(isset($_POST['password'])){
        $txt_password = $_POST['password'];
    }
    else return;
    if(isset($_POST['email'])){
        $txt_email = $_POST['email'];
    }
    else return;

    $now = date("Y-m-d H:i:s");
    $token = md5(generateRandomString(10) . $now);

    $query = "INSERT INTO `user` (`user_id`, `user_username`, `user_password`, `user_name`, `user_tel`, `user_email`, `user_type`, `user_token`) VALUES (NULL, ?, ?, NULL, NULL, ?, NULL, ?)";

    $stmt = $db->prepare($query);
    $stmt->execute([$txt_username, $txt_password, $txt_email, $token]);

    // ตรวจสอบและเก็บผลลัพธ์
    if ($stmt->rowCount() > 0) {
        $object = new stdClass();
        $result = new stdClass();

        $result->Username = $txt_username;
        $result->Email = $txt_email;

        $object->RespCode = 200;
        $object->RespMessage = 'Success';
        $object->Result = $result;
    } else {
        $object = new stdClass();
        $object->RespCode = 400;
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
