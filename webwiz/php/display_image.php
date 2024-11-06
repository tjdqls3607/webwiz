<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feel_flow_member";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$user_nickname = $_SESSION['user_nickname'];

// 사용자 닉네임을 이용하여 프로필 이미지를 가져오는 쿼리
$sql = "SELECT profile_image FROM users WHERE nickname = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $user_nickname); // nickname을 기준으로 가져오므로 "s" 사용
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    $stmt->bind_result($image_data);
    $stmt->fetch();

    // 이미지 데이터를 올바른 MIME 타입으로 출력
    header("Content-Type: image/png"); // 이미지 형식에 맞게 설정 (예: image/jpeg 또는 image/png)
    echo $image_data;
} else {
    // 프로필 이미지가 없는 경우 기본 이미지를 출력하거나 오류 처리
    header("Content-Type: image/png");
    echo file_get_contents("../imgsrc/noprofile.png");
}

$stmt->close();
$conn->close();
?>
