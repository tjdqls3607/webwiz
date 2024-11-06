<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "feel_flow_member";

// MySQL 연결
$conn = new mysqli($servername, $username, $password, $dbname);

// 연결 체크
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();

// 로그인 확인
if (!isset($_SESSION['user_nickname'])) {
    header("Location: login.php");
    exit();
}

// 파일 업로드 확인
if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
    // MIME 유형 확인
    $allowed_types = ['image/png', 'image/jpeg', 'image/gif'];
    $file_type = mime_content_type($_FILES['profile_image']['tmp_name']);

    if (!in_array($file_type, $allowed_types)) {
        echo json_encode(['status' => 'error', 'message' => '지원되지 않는 파일 형식입니다.']);
        exit();
    }

    // 파일 내용을 BLOB 데이터로 읽기
    $file_data = file_get_contents($_FILES['profile_image']['tmp_name']);
    $user_nickname = $_SESSION['user_nickname'];

    // 데이터베이스에 BLOB 데이터 저장
    $sql = "UPDATE users SET profile_image = ? WHERE nickname = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $file_data, $user_nickname);

    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => '프로필 사진이 업데이트되었습니다.']);
    } else {
        echo json_encode(['status' => 'error', 'message' => '데이터베이스 업데이트 실패']);
    }

    $stmt->close();
} else {
    echo json_encode(['status' => 'error', 'message' => '올바른 파일을 업로드하세요']);
}

$conn->close();
?>
